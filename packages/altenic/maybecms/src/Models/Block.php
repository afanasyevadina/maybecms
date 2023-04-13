<?php

namespace Altenic\MaybeCms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Collection;

class Block extends Model
{
    use HasFactory, HasBlocks, HasAttachments, HasUser;

    protected $guarded = [];

    protected $casts = [
        'active' => 'boolean',
        'content' => 'array',
        'query' => 'array',
    ];

    protected static function booted()
    {
        static::created(function (Block $block) {
            $block->update([
                'user_id' => auth()->id(),
                'active' => 1,
                'order' => $block->attachable?->blocks()->count(),
                'content' => $block->content ?? collect($block->structure ?? [])->map(fn($item) => [
                        $item['slug'] => [
                            'value' => array_keys($item['options'] ?? [])[0] ?? '',
                        ],
                    ])->collapse(),
                'post_type_id' => $block->attachable->post_type_id,
            ]);
        });

        static::deleting(function (Block $block) {
            foreach ($block->blocks as $subBlock) $subBlock->delete();
            foreach ($block->attachments as $attachment) $attachment->delete();
        });

        static::deleted(function (Block $block) {
            static::withoutEvents(function () use ($block) {
                foreach ($block->attachable->blocks as $key => $relatedBlock) {
                    $relatedBlock->order = $key + 1;
                    $relatedBlock->save();
                };
            });
        });
    }

    public function attachable(): MorphTo
    {
        return $this->morphTo();
    }

    public function postType(): BelongsTo
    {
        return $this->belongsTo(PostType::class);
    }

    public function component(): BelongsTo
    {
        return $this->belongsTo(Component::class);
    }

    public function getStructureAttribute()
    {
        return maybe_primitives()[$this->type]['structure'] ?? [];
    }

    public function getPostsAttribute(): ?Collection
    {
        if ($this->attachable_type == Post::class) {
            return collect([$this->attachable]);
        }
        return $this->postType?->posts;
    }

    public function getProperty(string $slug, $source = null)
    {
        if (!@$this->content[$slug]['source'])
            return $this->content[$slug]['value'] ?? '';
        if(@$this->content[$slug]['source'] == 'title')
            return $source?->title ?? '';
        if(@$this->content[$slug]['source'] == 'link')
            return url('/' . $source?->postType->slug . '/' . $source?->slug);
        if($fieldName = str_replace('field.', '', $this->content[$slug]['source'])) {
            return $source?->content[$fieldName]['value'] ?? '';
        }
    }

    public function getAttachment(string $slug, $source = null)
    {
        if (!@$this->content[$slug]['source'])
            return $this->attachments()->where('role', $slug)->first();
        if($fieldName = str_replace('field.', '', $this->content[$slug]['source'])) {
            return $source?->attachments()->where('role', $fieldName)->first();
        }
    }
}
