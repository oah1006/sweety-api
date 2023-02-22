<?php

namespace App\Actions;

use Illuminate\Http\UploadedFile;

class UploadAttachmentAction {
    public static function run (UploadedFile $file, $attachmentable, $directory, $disk = 'public') {
        $filename = $file->hashName();

        $pathFile = $file->storeAs(
            $directory,
            $filename,
            $disk
        );

        return $attachmentable->attachment()->create([
            'path' => $pathFile,
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'user_id' => auth()->user()->id
        ]);
    }
}
