<?php

namespace Altenic\MaybeCms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
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
                'slug' => Str::plural(create_slug($model)),
                'plural_title' => Str::plural($model->title),
            ]);
        });

        static::deleting(function (PostType $model) {
            foreach ($model->blocks as $block) $block->delete();
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

    public function blocks(): MorphMany
    {
        return $this->morphMany(Block::class, 'attachable')->orderBy('order');
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
