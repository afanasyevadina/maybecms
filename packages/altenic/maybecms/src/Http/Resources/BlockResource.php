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
            'slug' => $this->slug,
            'title' => $this->title,
            'content' => $this->resource->transformContent(),
            'class_name' => get_class($this->resource),
            'attachable_id' => $this->attachable_id,
            'attachable_type' => $this->attachable_type,
            'active' => $this->active,
            'order' => $this->order,
            'created_at' => Carbon::create($this->created_at)->toIso8601ZuluString(),
            'updated_at' => Carbon::create($this->updated_at)->toIso8601ZuluString(),
        ];
        if (in_array($this->type, ['video', 'image', 'link']))
            $data['attachment'] = AttachmentResource::make($this->attachment);
        if ($this->type == 'section')
            $data['blocks'] = BlockResource::collection($this->blocks);
        return $data;
    }
}
