<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    public function uploadFile(UploadedFile $file, string $path): string
    {
        $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $uniqueFileName = $originalFileName . '_' . time() . '_' . uniqid() . '.' . $extension;
        $finalPath = $file->storeAs($path, $uniqueFileName);
        return Storage::url($finalPath);
    }

    public function deleteFile(string $path): bool
    {
         $fullPath = 'public/' . $path;

        if (Storage::exists($fullPath)) {
            return Storage::delete($fullPath);
        }

        return false;
    }
    
}
