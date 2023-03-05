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

    public const PRIMITIVES = [
        [
            'type' => 'text',
            'title' => 'Text',
            'structure' => [
                'text' => '',
            ]
        ],
        [
            'type' => 'markdown',
            'title' => 'Markdown',
            'structure' => [
                'text' => '',
            ],
        ],
        [
            'type' => 'link',
            'title' => 'Link',
            'structure' => [
                'text' => '',
                'link' => '',
            ],
        ],
        [
            'type' => 'image',
            'title' => 'Image',
            'structure' => [
                'alt' => '',
                'wrapperClass' => '',
            ],
        ],
        [
            'type' => 'video',
            'title' => 'Video',
            'structure' => [
                'wrapperClass' => '',
            ],
        ],
    ];

    protected $guarded = [];

    protected $casts = [
        'active' => 'boolean',
        'content' => 'array',
    ];

    protected static function booted()
    {
        static::created(function (Block $block) {
            $block->update([
                'user_id' => auth()->id(),
                'active' => 1,
                'order' => $block->attachable?->blocks()->count(),
                'content' => $block->content ?? $block->structure,
            ]);
        });

        static::saved(function (Block $block) {
            static::withoutEvents(fn() => create_slug($block, 'title', '_'));
        });

        static::deleting(function (Block $block) {
            foreach ($block->blocks as $subBlock) $subBlock->delete();
            $block->attachment()->delete();
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

    public function attachment(): MorphOne
    {
        return $this->morphOne(Attachment::class, 'attachable');
    }

    public function blocks(): MorphMany
    {
        return $this->morphMany(Block::class, 'attachable')->orderBy('order');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('maybecms.user_model'))->withDefault();
    }

    public function getStructureAttribute()
    {
        return collect(static::PRIMITIVES)->where('type', $this->type)->pluck('structure')->first() ?? [];
    }

    public function transformContent(): array
    {
        $content = [];
        foreach ($this->structure ?? [] as $key => $value) {
            $content[$key] = $this->content[$key] ?? $value;
        }
        $content['class'] = $this->content['class'] ?? '';
        return $content;
    }
}
