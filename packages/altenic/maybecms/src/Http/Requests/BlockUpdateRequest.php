<?php

namespace Altenic\MaybeCms\Http\Requests;

class BlockUpdateRequest extends JsonRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'sometimes',
            'content' => 'sometimes',
            'active' => 'sometimes|boolean',
            'attachment' => 'sometimes|array',
            'attachment.file' => 'sometimes|array',
            'attachment.file.id' => 'sometimes|integer|exists:files,id',
        ];
    }
}
