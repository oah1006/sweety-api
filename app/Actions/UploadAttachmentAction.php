<?php

namespace App\Actions;

use App\Enums\AttachmentTypes;

class UploadAttachmentAction {

    public static function run (array $files, $attachmentable, AttachmentTypes $type, $disk = 'public') {
        $attachments = [];

        foreach ($files as $file) {
            $filename = $file->hashName();

            $pathFile = $file->storeAs(
                $type->value,
                $filename,
                $disk
            );

            $attachments[] = $attachmentable->attachment()->create([
                'path' => $pathFile,
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize(),
                'user_id' => auth()->user()->id
            ]);
        }

        return $attachments;
    }
}
