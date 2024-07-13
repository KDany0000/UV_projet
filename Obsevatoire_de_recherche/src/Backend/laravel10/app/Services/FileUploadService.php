<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    public function uploadFile(UploadedFile $file, string $path): string
    {
        $fileName = $file->getClientOriginalName();
        $finalPath = $file->storeAs($path, $fileName);
        return Storage::url($finalPath);
    }
}
