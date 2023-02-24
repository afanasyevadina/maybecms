<?php

namespace Altenic\MaybeCms\Http\Requests;

class PostUpdateRequest extends JsonRequest
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
            'title' => 'sometimes|filled',
            'description' => 'sometimes|present',
            'content' => 'sometimes|array',
            'fields' => 'sometimes|array',
            'active' => 'sometimes|boolean',
            'blocks' => 'sometimes|array',
            'blocks.*.id' => 'required',
            'blocks.*.blocks' => 'sometimes|array',
        ];
    }
}
