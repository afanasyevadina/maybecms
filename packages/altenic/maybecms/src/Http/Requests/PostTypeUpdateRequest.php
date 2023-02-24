<?php

namespace Altenic\MaybeCms\Http\Requests;

use Altenic\MaybeCms\Models\Block;
use Altenic\MaybeCms\Models\PostType;
use Altenic\MaybeCms\Models\Relation;
use Illuminate\Support\Str;

class PostTypeUpdateRequest extends JsonRequest
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
            'structure' => 'sometimes|array',
            'structure.relations' => 'sometimes|array',
            'structure.fields.*.type' => 'required|in:' . collect(Block::PRIMITIVES)->pluck('type')->implode(','),
            'structure.fields.*.title' => 'required',
            'structure.fields.*.slug' => 'required',
            'structure.supports' => 'sometimes|array',
            'structure.supports.*' => 'required|in:content,meta',
            'relations.*.id' => 'sometimes|exists:relations,id',
            'relations.*.type' => 'required|in:' . collect(Relation::TYPES)->pluck('type')->implode(','),
            'relations.*.title' => 'required',
            'relations.*.related_model_id' => 'required|in:' . PostType::pluck('id')->implode(','),
        ];
    }

    protected function prepareForValidation()
    {
        $structure = $this->input('structure') ?? [];
        $structure['relations'] = collect($structure['relations'] ?? [])->map(function ($relation) {
            $relation['slug'] = Str::slug($relation['title'] ?? '');
            return $relation;
        })->toArray();
        $structure['fields'] = collect($structure['fields'] ?? [])->map(function ($field) {
            $field['slug'] = Str::slug($field['title'] ?? '');
            return $field;
        })->toArray();
        $this->merge([
            'structure' => $structure,
        ]);
    }
}
