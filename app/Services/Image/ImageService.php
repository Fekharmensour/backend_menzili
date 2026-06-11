<?php

namespace App\Services\Image;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\Drivers\Imagick\Driver as ImagickDriver;

class ImageService
{
    protected ImageManager $manager;

    public function __construct()
    {
        $driver = null;

        try {
            if (extension_loaded('gd')) {
                $driver = new GdDriver();
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning("GD Driver Check Failed: " . $e->getMessage());
        }

        if (!$driver) {
            try {
                if (extension_loaded('imagick')) {
                    $driver = new ImagickDriver();
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::warning("Imagick Driver Check Failed: " . $e->getMessage());
            }
        }

        if ($driver) {
            $this->manager = new ImageManager($driver);
        } else {
            \Illuminate\Support\Facades\Log::error("Neither GD nor Imagick PHP extensions are working. WebP conversion is disabled.");
        }
    }

    /**
     * Store an uploaded image as WebP.
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param string $disk
     * @param int $quality
     * @return string
     */
    public function storeAsWebp(UploadedFile $file, string $directory, string $disk = 'public', int $quality = 80): string
    {
        // If manager is not available (drivers missing), fallback to original storage
        if (!isset($this->manager)) {
            \Illuminate\Support\Facades\Log::warning("WebP Conversion skipped for {$file->getClientOriginalName()} due to missing drivers.");
            return $file->store($directory, $disk);
        }

        $filename = \Illuminate\Support\Str::random(40) . '.webp';
        $path = $directory . '/' . $filename;
        \Illuminate\Support\Facades\Log::info("WebP Conversion: Saving {$file->getClientOriginalName()} to {$path}");

        try {
            $image = $this->manager->decode($file->getRealPath());
            $encoded = $image->encode(new WebpEncoder($quality));
            Storage::disk($disk)->put($path, (string) $encoded);
            return $path;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("WebP Conversion failed: " . $e->getMessage());
            return $file->store($directory, $disk);
        }
    }
}
