<?php

namespace Altenic\MaybeCms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class PostType extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'structure' => 'array',
    ];

    protected static function booted()
    {
        static::created(function (PostType $model) {
            $model->update([
                'user_id' => auth()->id(),
            ]);
        });

        static::saved(function (PostType $model) {
            static::withoutEvents(function () use ($model) {
                create_slug($model);
                $model->update(['plural_slug' => Str::plural($model->slug)]);
            });
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('maybecms.user_model'))->withDefault();
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function relations(): HasMany
    {
        return $this->hasMany(Relation::class);
    }

    public function inverseRelations(): HasMany
    {
        return $this->hasMany(Relation::class, 'related_post_type_id');
    }
}
