<?php

namespace Altenic\MaybeCms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function booted()
    {
        static::created(function (Field $field) {
            $field->update([
                'user_id' => auth()->id(),
                'content' => $field->structure,
            ]);
        });

        static::saved(function (Field $field) {
            static::withoutEvents(fn() => create_slug($field));
        });
    }

    public function attachable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }

    public function attachment(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(Attachment::class, 'attachable');
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(config('maybecms.user_model'))->withDefault();
    }
}
