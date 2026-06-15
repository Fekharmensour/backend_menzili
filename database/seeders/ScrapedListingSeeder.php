<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Listing;
use App\Models\Location;
use App\Models\Member;
use App\Models\User;
use App\Models\Wilaya;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Seeds the `listings` table (+ pivots, gallery images and listing agents)
 * from the scraped Ouedkniss dataset in database/seeders/data/listings_clean.json.
 *
 * Assumptions (everything else is already seeded):
 *   - categories / types / features / rent_durations IDs match the scraped IDs.
 *   - cities / wilayas already exist (matched here BY NAME, not by scraped id,
 *     because CitySeeder uses auto-increment ids that differ from Ouedkniss ids).
 *
 * What this seeder DOES create:
 *   - A User + Member for each scraped agent (members[0]). Listings with no
 *     agent fall back to a shared "Scraped Listings" owner.
 *   - A Location per resolved city (lat/lng are 0 in the source data).
 *   - The listing, its category/feature/near-place pivots, its gallery images.
 *
 * Images
 * ──────
 * Copy scraping/clean_data/images/ → storage/app/public/listings/
 * The seeder reads local files from there (watermark-free).
 * Falls back to downloading from the CDN URL if a local file is missing.
 */
class ScrapedListingSeeder extends Seeder
{
    /**
     * Absolute path to the folder that contains {listing_id}/main.jpg etc.
     * Set to null to always download from the CDN instead.
     */
    private const LOCAL_IMAGES_PATH = '/home/mensour/workflow/laravel/backend_menzili/storage/app/public/listings'; // set after copying: storage_path('app/public/listings')

    /** Public-disk sub-directories. */
    private const LISTINGS_DIR = 'listings';
    private const AVATARS_DIR = 'agents';

    /** Caches to keep the run idempotent and fast. */
    private array $cityIndex = [];   // normalized "city|wilaya" => city_id
    private array $cityByName = [];   // normalized "city"        => [city_id, ...]
    private array $locationCache = [];   // city_id                  => location_id
    private array $memberCache = [];   // scraped agent id         => member_id
    private ?int $fallbackMemberId = null;

    private int $created = 0;
    private int $skipped = 0;
    private array $unmatchedCities = [];

    // Valid IDs for pivots
    private array $validCategoryIds = [];
    private array $validFeatureIds  = [];
    private array $validNearPlaceIds = [];

    public function run(): void
    {
        $path = database_path('seeders/data/listings_clean.json');

        if (!is_file($path)) {
            $this->command->error("Scraped dataset not found at: {$path}");
            return;
        }

        $listings = json_decode(file_get_contents($path), true);

        if (!is_array($listings)) {
            $this->command->error('listings.json could not be decoded into an array.');
            return;
        }

        $this->buildCityIndex();
        $this->loadValidPivotIds();

        $bar = $this->command->getOutput()->createProgressBar(count($listings));
        $bar->start();

        foreach ($listings as $row) {
            $this->seedListing($row);
            $bar->advance();
        }

        $bar->finish();
        $this->command->newLine(2);

        $this->command->info("Listings created: {$this->created}");
        if ($this->skipped > 0) {
            $this->command->warn("Listings skipped: {$this->skipped}");
        }
        if ($this->unmatchedCities !== []) {
            $names = implode(', ', array_keys($this->unmatchedCities));
            $this->command->warn("Cities matched by fallback / wilaya only: {$names}");
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  Listing
    // ─────────────────────────────────────────────────────────────────────────

    private function seedListing(array $row): void
    {
        $locationId = $this->resolveLocationId($row['location'] ?? null);
        if ($locationId === null) {
            $this->skipped++;
            return;
        }

        $memberId = $this->resolveMemberId($row['members'][0] ?? null);
        $typeId = $row['type']['id'] ?? ($row['types'][0]['id'] ?? 1);
        $rentId = $row['rent_duration']['id'] ?? 1;

        $listing = Listing::create([
            'title' => $row['title'] ?? 'Untitled',
            'description' => $row['description'] ?? null,
            'price' => $row['price'] ?? 0,
            'floor' => $row['floor'] ?? null,
            'surface' => $row['surface'] ?? null,
            'min_duration' => $row['min_duration'] ?? null,
            'number_rooms' => $row['number_rooms'] ?? null,
            'number_persons' => $row['number_persons'] ?? null,
            'is_active' => $row['is_active'] ?? true,
            'is_ready' => $row['is_ready'] ?? true,
            'is_negotiable' => $row['is_negotiable'] ?? false,
            'verified_at' => now(),
            'moderation_status' => $row['moderation_status'] ?? 'approved',
            'main_image' => null, // Updated below
            'member_id' => $memberId,
            'rent_duration_id' => $rentId,
            'type_id' => $typeId,
            'location_id' => $locationId,
        ]);

        $listingDir = "listings/{$listing->id}";

        $mainImage = $this->resolveAndCopyImage(
            $row['local_main_image'] ?? null,
            $row['image'] ?? null,
            $listingDir
        );

        if ($mainImage) {
            $listing->update(['main_image' => $mainImage]);
        }

        $this->attachPivots($listing, $row);
        $this->seedGallery($listing, $row['images'] ?? [], $row['local_images'] ?? [], $listingDir);

        $this->created++;
    }

    private function attachPivots(Listing $listing, array $row): void
    {
        $categoryIds = collect($row['categories'] ?? [])->pluck('id')->intersect($this->validCategoryIds)->unique()->all();
        $featureIds  = collect($row['features']   ?? [])->pluck('id')->intersect($this->validFeatureIds)->unique()->all();
        $nearIds     = collect($row['near_places'] ?? [])->pluck('id')->intersect($this->validNearPlaceIds)->unique()->all();

        if ($categoryIds !== []) {
            $listing->categories()->syncWithoutDetaching($categoryIds);
        }
        if ($featureIds !== []) {
            $listing->features()->syncWithoutDetaching($featureIds);
        }
        if ($nearIds !== []) {
            $listing->nearPlaces()->syncWithoutDetaching($nearIds);
        }
    }

    private function seedGallery(Listing $listing, array $images, array $localImages = [], string $targetDir = 'listings'): void
    {
        // Prefer local watermark-free paths; fall back to CDN URLs
        $count = max(count($images), count($localImages));
        for ($i = 0; $i < $count; $i++) {
            $localPath = $localImages[$i] ?? null;
            $cdnUrl    = is_array($images[$i] ?? null)
                ? ($images[$i]['image'] ?? null)
                : ($images[$i] ?? null);
            $path = $this->resolveAndCopyImage($localPath, $cdnUrl, $targetDir);
            if ($path !== null) {
                $listing->images()->create(['path' => $path]);
            }
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  Members (created from scraped agents)
    // ─────────────────────────────────────────────────────────────────────────

    private function resolveMemberId(?array $agent): int
    {
        if ($agent === null || empty($agent['id'])) {
            return $this->fallbackMemberId();
        }

        $agentId = (int) $agent['id'];
        if (isset($this->memberCache[$agentId])) {
            return $this->memberCache[$agentId];
        }

        // Deterministic, collision-free identity derived from the scraped id,
        // so re-running the seeder reuses the same User/Member.
        $email = "agent{$agentId}@scraped.local";
        $phone = '+213' . str_pad((string) $agentId, 9, '0', STR_PAD_LEFT);

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $agent['name'] ?? "Agent {$agentId}",
                'phone' => $phone,
                'password' => Hash::make(Str::random(16)),
                'is_active' => true,
                'phone_verified_at' => now(),
                'profile_image' => $this->downloadImage($agent['profile_image'] ?? null, self::AVATARS_DIR),
            ]
        );

        $member = Member::firstOrCreate(
            ['user_id' => $user->id],
            [
                'member_verified_at' => !empty($agent['member_verified']) ? now() : null,
                'agent_verified_at' => !empty($agent['agent_verified']) ? now() : null,
            ]
        );

        return $this->memberCache[$agentId] = $member->id;
    }

    private function fallbackMemberId(): int
    {
        if ($this->fallbackMemberId !== null) {
            return $this->fallbackMemberId;
        }

        $user = User::firstOrCreate(
            ['email' => 'listings@scraped.local'],
            [
                'name' => 'Scraped Listings',
                'phone' => '+213000000000',
                'password' => Hash::make(Str::random(16)),
                'is_active' => true,
                'phone_verified_at' => now(),
            ]
        );

        $member = Member::firstOrCreate(
            ['user_id' => $user->id],
            ['member_verified_at' => now()],
        );

        return $this->fallbackMemberId = $member->id;
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  Location / City matching (BY NAME)
    // ─────────────────────────────────────────────────────────────────────────

    private function resolveLocationId(?array $location): ?int
    {
        if ($location === null) {
            return null;
        }

        $cityId = $this->matchCityId(
            $location['city'] ?? null,
            $location['wilaya'] ?? null,
        );

        if ($cityId === null) {
            return null;
        }

        if (isset($this->locationCache[$cityId])) {
            return $this->locationCache[$cityId];
        }

        $loc = Location::firstOrCreate(
            ['city_id' => $cityId],
            [
                'latitude' => $location['latitude'] ?? 0,
                'longitude' => $location['longitude'] ?? 0,
            ],
        );

        return $this->locationCache[$cityId] = $loc->id;
    }

    private function matchCityId(?string $city, ?string $wilaya): ?int
    {
        if (!$city) {
            return null;
        }

        $cityKey = $this->normalize($city);
        $wilayaKey = $this->normalize((string) $wilaya);

        // 1. Exact city + wilaya match.
        if (isset($this->cityIndex["{$cityKey}|{$wilayaKey}"])) {
            return $this->cityIndex["{$cityKey}|{$wilayaKey}"];
        }

        // 2. City name alone (ignoring wilaya).
        if (isset($this->cityByName[$cityKey])) {
            $this->unmatchedCities[$city] = true;
            return $this->cityByName[$cityKey][0];
        }

        // 3. Any city inside the matched wilaya.
        if ($wilayaKey !== '' && isset($this->cityIndex["__wilaya__|{$wilayaKey}"])) {
            $this->unmatchedCities[$city] = true;
            return $this->cityIndex["__wilaya__|{$wilayaKey}"];
        }

        return null;
    }

    private function buildCityIndex(): void
    {
        $wilayas = Wilaya::all(['id', 'name_en', 'name_ar']);
        $wilayaKeyById = [];
        foreach ($wilayas as $w) {
            foreach ([$w->name_en, $w->name_ar] as $name) {
                if ($name) {
                    $wilayaKeyById[$w->id][] = $this->normalize($name);
                }
            }
        }

        foreach (City::all(['id', 'name_en', 'name_ar', 'wilaya_id']) as $c) {
            $cityKeys = array_filter([
                $c->name_en ? $this->normalize($c->name_en) : null,
                $c->name_ar ? $this->normalize($c->name_ar) : null,
            ]);

            foreach ($cityKeys as $cityKey) {
                $this->cityByName[$cityKey] ??= [];
                $this->cityByName[$cityKey][] = $c->id;

                foreach ($wilayaKeyById[$c->wilaya_id] ?? [] as $wilayaKey) {
                    $this->cityIndex["{$cityKey}|{$wilayaKey}"] ??= $c->id;
                    $this->cityIndex["__wilaya__|{$wilayaKey}"] ??= $c->id;
                }
            }
        }
    }

    private function loadValidPivotIds(): void
    {
        $this->validCategoryIds  = \App\Models\Category::pluck('id')->all();
        $this->validFeatureIds   = \App\Models\Feature::pluck('id')->all();
        $this->validNearPlaceIds = \App\Models\NearPlace::pluck('id')->all();
    }

    /** Lowercase, strip accents and collapse to single spaces for fuzzy matching. */
    private function normalize(string $value): string
    {
        $value = Str::lower(trim($value));
        $ascii = @iconv('UTF-8', 'ASCII//TRANSLIT', $value);
        if ($ascii !== false) {
            $value = $ascii;
        }
        $value = preg_replace('/[^a-z0-9\x{0600}-\x{06FF}]+/u', ' ', $value);

        return trim(preg_replace('/\s+/', ' ', $value));
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  Images
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Returns the storage-relative path for an image.
     * Tries the local dewatermarked file first; falls back to CDN download.
     * Copies the file to the target local directory.
     */
    private function resolveAndCopyImage(?string $localRelPath, ?string $cdnUrl, string $targetDir): ?string
    {
        // ── Try local dewatermarked file ──────────────────────────────────────
        if ($localRelPath && self::LOCAL_IMAGES_PATH) {
            $absSourcePath = rtrim(self::LOCAL_IMAGES_PATH, '/') . '/' . $localRelPath;

            if (file_exists($absSourcePath)) {
                $filename = basename($localRelPath);
                $storageRelativePath = rtrim($targetDir, '/') . '/' . $filename;

                if (!Storage::disk('public')->exists($storageRelativePath)) {
                    Storage::disk('public')->put($storageRelativePath, file_get_contents($absSourcePath));
                }
                return $storageRelativePath;
            }
        }

        // ── Fall back to CDN download ─────────────────────────────────────────
        return $this->downloadImage($cdnUrl, $targetDir);
    }

    /**
     * Downloads a remote image from the CDN into the public disk.
     * Returns the storage-relative path, or null on failure.
     */
    private function downloadImage(?string $url, string $targetDir = 'listings'): ?string
    {
        if (!$url) {
            return null;
        }

        try {
            $ext          = strtolower(pathinfo(parse_url($url, PHP_URL_PATH) ?? '', PATHINFO_EXTENSION) ?: 'jpg');
            $relativePath = rtrim($targetDir, '/') . '/' . md5($url) . ".{$ext}";

            if (Storage::disk('public')->exists($relativePath)) {
                return $relativePath;
            }

            $response = Http::timeout(20)->retry(2, 500)->get($url);
            if (!$response->successful()) {
                $this->command->warn("Image download failed ({$response->status()}): {$url}");
                return null;
            }

            Storage::disk('public')->put($relativePath, $response->body());

            return $relativePath;
        } catch (\Throwable $e) {
            $this->command->warn("Image download error: {$url} — {$e->getMessage()}");
            return null;
        }
    }
}
