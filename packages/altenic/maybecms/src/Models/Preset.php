<?php

namespace Altenic\MaybeCms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Preset extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::created(function(Preset $preset) {
            $preset->update([
                'user_id' => auth()->id(),
                'slug' => Str::slug($preset->title ?? $preset->id),
            ]);
        });

        static::saved(function (Preset $preset) {
            static::withoutEvents(fn() => create_slug($preset));
        });
    }

    protected $guarded = [];

    protected $casts = [
        'blocks' => 'array',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(config('maybecms.user_model'))->withDefault();
    }
}
