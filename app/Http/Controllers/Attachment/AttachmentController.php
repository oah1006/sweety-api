<?php

namespace App\Http\Controllers\Attachment;

use App\Actions\DetachAttachmentAction;
use App\Actions\UploadAttachmentAction;
use App\Enums\AttachmentTypes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Attachment\CreateAttachmentRequest;
use App\Models\Attachment;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;

class AttachmentController extends Controller
{
    public function store(CreateAttachmentRequest $request, string $attachmentableName, int $attachmentableId) {
        $data = $request->validated();

        $attachmentableClass = Relation::getMorphedModel($attachmentableName);
        $attachmentable = $attachmentableClass::findOrFail($attachmentableId);

        $attachment = UploadAttachmentAction::run($request->file('file'), $attachmentable, AttachmentTypes::tryFrom($data['type']));

        return response()->json([
            'id' => $attachmentableId,
            'data' => $attachment,
            'hello'
        ]);
    }

    public function detach(Attachment $attachment) {
        DetachAttachmentAction::run($attachment);

        return response()->noContent();
    }
}
