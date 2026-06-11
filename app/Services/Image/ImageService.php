<?php

namespace App\Services\Image;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;

class ImageService
{
    protected ImageManager $manager;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
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
