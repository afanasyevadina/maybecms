<?php

namespace Altenic\MaybeCms\Http\Controllers\Api;

use Altenic\MaybeCms\Http\Controllers\Controller;
use Altenic\MaybeCms\Http\Requests\PostCreateRequest;
use Altenic\MaybeCms\Http\Requests\PostUpdateRequest;
use Altenic\MaybeCms\Http\Resources\PostListResource;
use Altenic\MaybeCms\Http\Resources\PostResource;
use Altenic\MaybeCms\Models\PostType;
use Altenic\MaybeCms\Models\Post;

class PostController extends Controller
{
    use Blockable;

    public function index(string $postType)
    {
        $model = PostType::query()->where('slug', $postType)->firstOrFail();
        return PostListResource::collection(Post::byType($model->id)->paginate(20));
    }

    public function show(string $postType, Post $post)
    {
        return PostResource::make($post);
    }

    public function store($postType, PostCreateRequest $request)
    {
        $model = PostType::query()->where('slug', $postType)->firstOrFail();
        $post = $model->posts()->create($request->validated());
        return response()->json([
            'status' => 'success',
            'data' => PostResource::make($post),
        ], 201);
    }

    public function update(string $postType, Post $post, PostUpdateRequest $request)
    {
        $this->updateContent($post, $request->safe()->except(['blocks', 'meta', 'relations']));
        $this->updateBlocks($post, $request->input('blocks') ?? []);
        foreach ($request->input('relations') as $relation) {
            $modelRelation = $post->relations()->find($relation['id']);
            $relatedPosts = $modelRelation?->type == 'has-one' ? [$relation['related_post']] : ($relation['related_posts'] ?? []);
            $post->posts()->wherePivot('relation_id', $modelRelation?->id)->whereNotIn('related_post_id', $relatedPosts)->detach();
            $post->posts()->attach(array_filter($relatedPosts), [
                'relation_id' => $modelRelation?->id,
            ]);
        }
        return response()->json([
            'status' => 'success',
            'data' => PostResource::make($post),
        ]);
    }

    public function destroy(string $postType, Post $post)
    {
        $post->delete();
        return response()->noContent();
    }
}
