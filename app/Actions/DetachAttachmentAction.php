<?php

namespace App\Actions;

use Illuminate\Support\Facades\Storage;

class DetachAttachmentAction {
    public static function run($attachment) {
        $pathFile = $attachment->path;

        Storage::delete($pathFile);
        $attachment->delete();
    }
}
