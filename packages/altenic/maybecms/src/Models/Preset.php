<?php

namespace Altenic\MaybeCms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;

class Preset extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::created(function(Preset $preset) {
            $preset->update([
                'user_id' => auth()->id(),
            ]);
        });

        static::deleting(function (Preset $preset) {
            foreach ($preset->blocks as $block) $block->delete();
        });
    }

    protected $guarded = [];

    public function blocks(): MorphMany
    {
        return $this->morphMany(Block::class, 'attachable')->orderBy('order');
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(config('maybecms.user_model'))->withDefault();
    }
}
