<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Storage;

class ImageUpload
{
    public static function upload($file, $path = 'images'): string
    {
        return $file->store($path, 'public');
    }
    
    public static function delete($path): void
    {
        if (Storage::exists('public/' . $path)) {
            Storage::delete('public/' . $path);
        }
    }
}
