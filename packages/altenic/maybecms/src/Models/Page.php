<?php

namespace Altenic\MaybeCms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Page extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::created(function (Page $page) {
            $page->update([
                'user_id' => auth()->id(),
                'active' => 1,
            ]);
            create_slug($page);
        });

        static::deleting(function (Page $page) {
            foreach ($page->blocks as $block) $block->delete();
            if ($meta = $page->meta()->first()) $meta->delete();
        });
    }

    protected $guarded = [];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function blocks(): MorphMany
    {
        return $this->morphMany(Block::class, 'attachable')->orderBy('order');
    }

    public function meta(): MorphOne
    {
        return $this->morphOne(Meta::class, 'attachable');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('maybecms.user_model'))->withDefault();
    }
}
