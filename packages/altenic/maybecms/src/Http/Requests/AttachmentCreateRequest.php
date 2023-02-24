<?php

namespace Altenic\MaybeCms\Http\Requests;

class AttachmentCreateRequest extends JsonRequest
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
            'attachable_type' => str_replace("\\\\", "\\", $this->input('attachable_type')),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'attachable_id' => 'required',
            'attachable_type' => 'required',
            'type' => 'required|in:image,video,file',
            'file' => 'required|file' . ($this->input('type') == 'image' ? '|image' : '') . ($this->input('type') == 'video' ? '|mimetypes:video/*' : ''),
        ];
        if($this->input('type') == 'image') $rules['alt'] = 'sometimes';
        return $rules;
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $className = $this->input('attachable_type');
            if (!class_exists($className)) {
                $validator->errors()->add('attachable_type', 'Attachable class not exists.');
            } elseif(!$className::find($this->input('attachable_id'))) {
                $validator->errors()->add('attachable_id', 'Attachable model not found.');
            }
        });
    }
}
