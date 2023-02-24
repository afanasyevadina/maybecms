<?php

namespace Altenic\MaybeCms\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class RelationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'title' => $this->title,
            'type' => $this->type,
            'post_type' => $this->post_type,
            'related_model_id' => $this->related_model_id,
            'model' => [
                'id' => $this->postType->id,
                'slug' => $this->postType->slug,
                'plural_slug' => $this->postType->plural_slug,
                'title' => $this->postType->title,
            ],
            'related_model' => [
                'id' => $this->relatedPostType->id,
                'slug' => $this->relatedPostType->slug,
                'plural_slug' => $this->relatedPostType->plural_slug,
                'title' => $this->relatedPostType->title,
            ],
        ];
    }
}
