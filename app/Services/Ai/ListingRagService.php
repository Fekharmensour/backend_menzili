<?php

namespace App\Services\Ai;

use App\Models\Listing;
use App\Models\Wilaya;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Laravel\Ai\Ai;

class ListingRagService
{
    /**
     * Main search method (SQL + Vector hybrid search)
     * Stage-based filtering: Exact -> Relaxed -> Empty
     */
    public function search(array $filters)
    {
        $filters = $this->normalizeFilters($filters);

        // 1. TRY EXACT MATCH FIRST
        $results = $this->performSearch($filters);

        if ($results->isNotEmpty()) {
            return [
                'type' => 'exact',
                'items' => $results,
            ];
        }

        // 2. LOCATION FALLBACK: try city if wilaya-first search found nothing
        $cityFallbackFilters = $this->buildCityFallbackFilters($filters);

        if ($cityFallbackFilters !== null) {
            $cityFallbackResults = $this->performSearch($cityFallbackFilters);

            if ($cityFallbackResults->isNotEmpty()) {
                return [
                    'type' => 'location_city_fallback',
                    'items' => $cityFallbackResults,
                ];
            }
        }

        // 3. RELAXED SEARCH (Price OR Rooms)
        // Only if we have at least wilaya or purpose (Hard filters)
        $relaxedResults = collect();
        $relaxedType = null;

        // Try relaxing price (up to 20% higher)
        if (!empty($filters['max_price'])) {
            $relaxedFilters = $filters;
            $relaxedFilters['max_price'] = $filters['max_price'] * 1.2;
            $relaxedResults = $this->performSearch($relaxedFilters);
            if ($relaxedResults->isNotEmpty()) {
                $relaxedType = 'price_relaxed';
            }
        }

        // If still empty, try relaxing rooms (+/- 1)
        if ($relaxedResults->isEmpty() && !empty($filters['rooms'])) {
            $relaxedFilters = $filters;
            $relaxedFilters['rooms'] = max(1, $filters['rooms'] - 1);
            $relaxedResults = $this->performSearch($relaxedFilters);
            if ($relaxedResults->isNotEmpty()) {
                $relaxedType = 'rooms_relaxed';
            }
        }

        if ($relaxedResults->isNotEmpty()) {
            return [
                'type' => $relaxedType,
                'items' => $relaxedResults,
            ];
        }

        // 4. NO RESULTS
        return [
            'type' => 'no_results',
            'items' => collect(),
        ];
    }

    /**
     * Internal search logic (SQL + Vector)
     */
    private function performSearch(array $filters)
    {
        // 1. BASE QUERY (Hard filters first)
        $query = Listing::query()
            ->where('is_active', true);

        // HARD FILTER: Wilaya (Exact Match)
        if (!empty($filters['wilaya'])) {
            $query->whereHas('location.city.wilaya', function ($q) use ($filters) {
                $q->where('name_en', 'like', $filters['wilaya'])
                  ->orWhere('name_ar', 'like', $filters['wilaya']);
            });
        }

        // HARD FILTER: Purpose (Exact Match)
        if (!empty($filters['purpose'])) {
            $query->whereHas('type', function ($q) use ($filters) {
                $purpose = $filters['purpose'];
                if (strtolower($purpose) === 'sale') $purpose = 'sell';
                $q->where('name_en', 'like', $purpose)
                  ->orWhere('name_fr', 'like', $purpose)
                  ->orWhere('name_ar', 'like', $purpose);
            });
        }

        // City (Specific location)
        if (!empty($filters['city'])) {
            $query->whereHas('location.city', function ($q) use ($filters) {
                $q->where('name_en', 'like', '%' . $filters['city'] . '%')
                  ->orWhere('name_ar', 'like', '%' . $filters['city'] . '%');
            });
        }

        // SOFT FILTER: Price
        if (!empty($filters['max_price'])) {
            $query->where('price', '<=', $filters['max_price']);
        }

        // SOFT FILTER: Rooms
        if (!empty($filters['rooms'])) {
            $query->where('number_rooms', '>=', $filters['rooms']);
        }

        // Soft Filter: Persons
        if (!empty($filters['persons'])) {
            $query->where('number_persons', '>=', $filters['persons']);
        }

        // Features
        if (!empty($filters['features'])) {
            foreach ($filters['features'] as $feature) {
                $query->whereHas('features', function ($q) use ($feature) {
                    $q->where('name_en', 'like', '%' . $feature . '%')
                      ->orWhere('name_fr', 'like', '%' . $feature . '%')
                      ->orWhere('name_ar', 'like', '%' . $feature . '%');
                });
            }
        }

        // Near Places
        if (!empty($filters['near_places'])) {
            foreach ($filters['near_places'] as $place) {
                $query->whereHas('nearPlaces', function ($q) use ($place) {
                    $q->where('name_en', 'like', '%' . $place . '%')
                      ->orWhere('name_fr', 'like', '%' . $place . '%')
                      ->orWhere('name_ar', 'like', '%' . $place . '%');
                });
            }
        }

        $ids = $query->pluck('id');

        if ($ids->isEmpty()) {
            return collect();
        }

        // 2. SEMANTIC SEARCH
        $semanticText = $this->buildSemanticText($filters);
        $response = Ai::embeddings([$semanticText]);
        $vector = json_encode($response->embeddings[0]);

        $results = DB::table('listing_embeddings')
            ->whereIn('listing_id', $ids)
            ->orderByRaw('embedding <=> ?', [$vector])
            ->limit(10)
            ->get();

        return $this->hydrateResults($results);
    }

    /**
     * Build better embedding input (CRITICAL for quality)
     */
    private function buildSemanticText(array $filters): string
    {
        return collect([
            $filters['purpose'] ?? null,
            $filters['city'] ?? null,
            $filters['wilaya'] ?? null,
            isset($filters['max_price']) ? "budget around {$filters['max_price']} dinars" : null,
            isset($filters['rooms']) ? "{$filters['rooms']} bedrooms" : null,
            isset($filters['persons']) ? "for {$filters['persons']} people" : null,
            !empty($filters['features']) ? "features: " . implode(', ', $filters['features']) : null,
            !empty($filters['near_places']) ? "near: " . implode(', ', $filters['near_places']) : null,
        ])->filter()->implode(' | ');
    }

    /**
     * Convert embeddings → real listings + ranking boost
     */
    private function hydrateResults($results)
    {
        $ids = $results->pluck('listing_id');

        $listings = Listing::with([
            'location.city.wilaya',
            'type',
            'features'
        ])
            ->whereIn('id', $ids)
            ->get()
            ->keyBy('id');

        return $results->map(function ($item) use ($listings) {

            $listing = $listings[$item->listing_id] ?? null;

            if (!$listing) return null;

            return [
                'listing' => $listing,
                'score' => $item->distance ?? null,
                'rank' => $listing->final_score ?? 0,
            ];
        })
            ->filter()
            ->sortByDesc('rank')
            ->values();
    }

    private function normalizeFilters(array $filters): array
    {
        $filters['city'] = $this->normalizeNullableString($filters['city'] ?? null);
        $filters['wilaya'] = $this->normalizeNullableString($filters['wilaya'] ?? null);
        $filters['purpose'] = $this->normalizePurpose($filters['purpose'] ?? null);
        $filters['max_price'] = $this->normalizeNullableNumber($filters['max_price'] ?? null);
        $filters['rooms'] = $this->normalizeNullableNumber($filters['rooms'] ?? null);
        $filters['persons'] = $this->normalizeNullableNumber($filters['persons'] ?? null);
        $filters['features'] = $this->normalizeStringList($filters['features'] ?? []);
        $filters['near_places'] = $this->normalizeStringList($filters['near_places'] ?? []);

        $filters = $this->promoteWilayaLocation($filters);

        return $filters;
    }

    private function normalizeNullableString(mixed $value): ?string
    {
        if (! is_string($value)) {
            return null;
        }

        $value = trim($value);

        return $value !== '' ? $value : null;
    }

    private function normalizeNullableNumber(mixed $value): int|float|null
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (! is_numeric($value)) {
            return null;
        }

        return $value + 0;
    }

    private function normalizeStringList(mixed $values): array
    {
        if (! is_array($values)) {
            return [];
        }

        return collect($values)
            ->filter(fn ($value) => is_string($value))
            ->map(fn (string $value) => trim($value))
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    private function normalizePurpose(mixed $value): ?string
    {
        $value = strtolower((string) $this->normalizeNullableString($value));

        return match ($value) {
            'rent', 'sale', 'exchange' => $value,
            'sell' => 'sale',
            default => null,
        };
    }

    private function promoteWilayaLocation(array $filters): array
    {
        $normalizedWilaya = $this->resolveWilayaName($filters['wilaya']);
        $normalizedCityAsWilaya = $this->resolveWilayaName($filters['city']);

        if ($normalizedWilaya !== null) {
            $filters['wilaya'] = $normalizedWilaya;
        }

        if ($normalizedCityAsWilaya !== null) {
            $filters['wilaya'] ??= $normalizedCityAsWilaya;
            $filters['city'] = null;
        }

        if (
            $filters['city'] !== null &&
            $filters['wilaya'] !== null &&
            Str::lower($filters['city']) === Str::lower($filters['wilaya'])
        ) {
            $filters['city'] = null;
        }

        return $filters;
    }

    private function resolveWilayaName(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $wilaya = Wilaya::query()
            ->whereRaw('LOWER(name_en) = ?', [Str::lower($value)])
            ->orWhere('name_ar', $value)
            ->first();

        return $wilaya?->name_en;
    }

    private function buildCityFallbackFilters(array $filters): ?array
    {
        if ($filters['wilaya'] === null || $filters['city'] !== null) {
            return null;
        }

        return [
            ...$filters,
            'city' => $filters['wilaya'],
            'wilaya' => null,
        ];
    }
}
