<?php
namespace App\Actions;

use auth;
use App\Models\File;
use Illuminate\Http\UploadedFile;

class UploadFileAction {
    public static function run(UploadedFile $file, $relationship, $directoty, $disk = 'public') {
        $file_name = $file->hashName();
        $pathFile = $file->storeAs(
            $directoty,
            $file_name . '.' . $file->extension(),
            $disk
        );

        return $relationship->file()->create([
            'file_name' => $file_name,
            'file_path' => $pathFile,
            'file_type' => $file->extension(),
            'file_size' => $file->getSize(),
            'user_id' => auth()->user()->id
        ]);
    }
}