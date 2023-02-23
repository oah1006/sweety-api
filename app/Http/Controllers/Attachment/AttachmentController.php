<?php

namespace App\Http\Controllers\Attachment;

use App\Actions\DetachAttachmentAction;
use App\Actions\UploadAttachmentAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Attachment\CreateAttachmentRequest;
use App\Models\Attachment;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;

class AttachmentController extends Controller
{
    public function store(CreateAttachmentRequest $request) {
        $data = $request->validated();

        $attachmentableClass = Relation::getMorphedModel($data['attachmentable_type']);
        $attachmentable = $attachmentableClass::findOrFail($data['attachmentable_id']);

        $attachment = UploadAttachmentAction::run($request->file('file'), $attachmentable, $data['directory']);

        return response()->json([
            'data' => $attachment
        ]);
    }

    public function detach(Attachment $attachment) {
        DetachAttachmentAction::run($attachment);

        return response()->noContent();
    }
}
