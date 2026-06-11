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
        $driver = extension_loaded('gd') ? new GdDriver() : (extension_loaded('imagick') ? new ImagickDriver() : null);

        if (!$driver) {
            throw new \RuntimeException("Neither GD nor Imagick PHP extensions are available. Please install one of them to process images.");
        }

        $this->manager = new ImageManager($driver);
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
        $filename = \Illuminate\Support\Str::random(40) . '.webp';
        $path = $directory . '/' . $filename;
        \Illuminate\Support\Facades\Log::info("WebP Conversion: Saving {$file->getClientOriginalName()} to {$path}");

        $image = $this->manager->decodePath($file->getRealPath());
        $encoded = $image->encode(new WebpEncoder($quality));

        Storage::disk($disk)->put($path, (string) $encoded);

        return $path;
    }
}
