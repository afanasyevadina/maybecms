<?php

namespace Altenic\MaybeCms\Http\Controllers\Api;

use Altenic\MaybeCms\Http\Controllers\Controller;
use Altenic\MaybeCms\Http\Requests\AttachmentCreateRequest;
use Altenic\MaybeCms\Http\Requests\AttachmentUpdateRequest;
use Altenic\MaybeCms\Http\Resources\AttachmentResource;
use Altenic\MaybeCms\Models\Attachment;

class AttachmentController extends Controller
{
    public function store(AttachmentCreateRequest $request)
    {
        $attachment = Attachment::create($request->safe()->except('file'));
        return response()->json([
            'status' => 'success',
            'data' => AttachmentResource::make($attachment),
        ], 201);
    }

    public function update(Attachment $attachment, AttachmentUpdateRequest $request)
    {
        $attachment->update($request->safe()->except('file'));
        return response()->json([
            'status' => 'success',
            'data' => AttachmentResource::make($attachment),
        ]);
    }

    public function destroy(Attachment $attachment)
    {
        $attachment->delete();
        return response()->noContent();
    }
}
