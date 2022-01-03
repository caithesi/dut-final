<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait StorageImageTraits
{
    public function storageTraitUpload($request, $fieldName, $dir)
    {
        if (!$request->hasFile($fieldName)) {
            return null;
        }
        $file = $request->file($fieldName);
        $fileNameOrigin = $file->getClientOriginalName();
        $fileNameHash = Str::random(20) . '.' . $file->extension();
        $path = $request->file($fieldName)
            ->storeAs(
                'public/' . $dir . '/' . auth()->id(),
                $fileNameHash
            );
        return [
            'file_path' => Storage::url($path),
            'file_origin' =>  $fileNameOrigin,
        ];
    }

    public function storageTraitUploadMultiple($file, $dir)
    {
        $fileNameOrigin = $file->getClientOriginalName();
        $fileNameHash = Str::random(20) . '.' . $file->extension();
        $path = $file->storeAs(
            'public/' . $dir . '/' . auth()->id(),
            $fileNameHash
        );
        return [
            'file_path' => Storage::url($path),
            'file_origin' =>  $fileNameOrigin,
        ];
    }
}
