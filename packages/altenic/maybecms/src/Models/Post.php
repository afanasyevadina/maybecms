<?php

namespace Altenic\MaybeCms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Post extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'content' => 'array',
        'active' => 'boolean',
    ];

    protected static function booted()
    {
        static::created(function(Post $post) {
            $post->update([
                'user_id' => auth()->id(),
                'active' => 1,
            ]);
        });

        static::saved(function (Post $post) {
            static::withoutEvents(fn() => create_slug($post));
        });

        static::deleting(function (Post $post) {
            foreach ($post->blocks as $block) $block->delete();
            if ($meta = $post->meta()->first()) $meta->delete();
            $post->posts()->detach();
            $post->inversePosts()->detach();
        });
    }

    public function scopeByType($query, $type)
    {
        return $query->where('post_type_id', $type);
    }

    public function blocks(): MorphMany
    {
        return $this->morphMany(Block::class, 'attachable')->orderBy('order');
    }

    public function meta(): MorphOne
    {
        return $this->morphOne(Meta::class, 'attachable');
    }

    public function fields(): MorphMany
    {
        return $this->morphMany(Field::class, 'attachable');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('maybecms.user_model'))->withDefault();
    }

    public function postType(): BelongsTo
    {
        return $this->belongsTo(\Altenic\MaybeCms\Models\PostType::class)->withDefault();
    }

    public function relations()
    {
        return $this->hasManyThrough(Relation::class, \Altenic\MaybeCms\Models\PostType::class, 'id', 'post_type_id', 'related_post_type_id', 'id');
    }

    public function inverseRelations()
    {
        return $this->hasManyThrough(Relation::class, \Altenic\MaybeCms\Models\PostType::class, 'id', 'related_post_type_id', 'post_type_id', 'id');
    }

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'post_post', 'post_id', 'related_post_id')->withTimestamps();
    }

    public function inversePosts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'post_post', 'related_post_id', 'post_id')->withTimestamps();
    }

    public function getRelated($relation, $additionalQuery = null)
    {
        $modelRelation = $this->relations()->where('slug', $relation)->first();
        $query = $this->posts()->byType($modelRelation?->post_type_id)->wherePivot('relation_id', $modelRelation?->id);
        if ($additionalQuery instanceof \Closure) $query = $additionalQuery($query);
        return $modelRelation?->type == 'has-one' ? $query->first() : $query->get();
    }
}
