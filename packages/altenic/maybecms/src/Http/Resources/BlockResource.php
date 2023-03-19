<?php

namespace Altenic\MaybeCms\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class BlockResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'type' => $this->type,
            'title' => $this->title,
            'content' => collect($this->structure ?? [])->map(function($item) {
                $item['value'] = $this->content[$item['slug']] ?? '';
                $item['attachment'] = AttachmentResource::make($this->attachments()->where(['role' => $item['slug']])->first());
                return $item;
            })->toArray(),
            'children' => maybe_primitives()[$this->type]['children'] ?? [],
            'class_name' => 'block',
            'post_type_id' => $this->post_type_id,
            'active' => $this->active,
            'order' => $this->order,
            'blocks' => BlockResource::collection($this->blocks),
            'created_at' => Carbon::create($this->created_at)->toIso8601ZuluString(),
            'updated_at' => Carbon::create($this->updated_at)->toIso8601ZuluString(),
        ];
        return $data;
    }
}
