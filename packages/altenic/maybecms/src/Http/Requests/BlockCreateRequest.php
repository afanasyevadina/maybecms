<?php

namespace Altenic\MaybeCms\Http\Requests;

use Altenic\MaybeCms\Models\Block;
use Altenic\MaybeCms\Models\Page;
use Altenic\MaybeCms\Models\Post;
use Altenic\MaybeCms\Models\Preset;

class BlockCreateRequest extends JsonRequest
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

    protected function prepareForValidation()
    {
        $this->merge([
            'attachable_type' => maybe_attachable_class($this->input('attachable_type')),
            'title' => maybe_primitives()[$this->input('type')]['title'] ?? 'Секция',
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'attachable_id' => 'required',
            'attachable_type' => 'required|in:' . implode(',', [Page::class, Post::class, Preset::class, Block::class]),
            'post_type' => 'sometimes',
            'type' => 'required|in:' . collect(maybe_primitives())->keys()->implode(','),
            'title' => 'sometimes',
        ];
    }
}
