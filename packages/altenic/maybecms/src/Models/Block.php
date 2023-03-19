<?php

namespace Altenic\MaybeCms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Block extends Model
{
    use HasFactory;

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
                'content' => $block->content ?? collect($block->structure ?? [])->map(fn($item) => [$item['slug'] => array_keys($item['options'] ?? [])[0] ?? ''])->collapse(),
            ]);
        });

        static::deleting(function (Block $block) {
            foreach ($block->blocks as $subBlock) $subBlock->delete();
            foreach ($block->attachments as $attachment) $attachment->delete();
        });

        static::deleted(function (Block $block) {
            static::withoutEvents(function () use($block) {
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

    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function blocks(): MorphMany
    {
        return $this->morphMany(Block::class, 'attachable')->orderBy('order');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('maybecms.user_model'))->withDefault();
    }

    public function postType(): BelongsTo
    {
        return $this->belongsTo(PostType::class);
    }

    public function getStructureAttribute()
    {
        return maybe_primitives()[$this->type]['structure'] ?? [];
    }
}
