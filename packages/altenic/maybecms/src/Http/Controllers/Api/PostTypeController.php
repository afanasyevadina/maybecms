<?php

namespace Altenic\MaybeCms\Http\Controllers\Api;

use Altenic\MaybeCms\Http\Controllers\Controller;
use Altenic\MaybeCms\Http\Requests\PostTypeCreateRequest;
use Altenic\MaybeCms\Http\Requests\PostTypeUpdateRequest;
use Altenic\MaybeCms\Http\Resources\PostTypeResource;
use Altenic\MaybeCms\Models\PostType;

class PostTypeController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => PostType::all()->map(function ($model) {
                return [
                    'id' => $model->id,
                    'slug' => $model->slug,
                    'title' => $model->title,
                    'plural_title' => $model->plural_title,
                ];
            }),
        ]);
    }

    public function show(PostType $postType)
    {
        return PostTypeResource::make($postType);
    }

    public function store(PostTypeCreateRequest $request)
    {
        $model = PostType::create($request->validated());
        return response()->json([
            'status' => 'success',
            'data' => PostTypeResource::make($model),
        ], 201);
    }

    public function update(PostType $postType, PostTypeUpdateRequest $request)
    {
        $postType->update($request->safe()->except('relations'));
        $relations = collect($request->input('relations') ?? [])->map(function ($item) use($postType) {
            $item = collect($item)->only(['id', 'title', 'type', 'related_post_type_id'])->toArray();
            if (isset($item['id'])) {
                $relation = $postType->relations()->findOrFail($item['id']);
                $relation->update($item);
            } else $relation = $postType->relations()->create($item);
            return $relation->id;
        });
        $postType->relations()->whereNotIn('id', $relations)->delete();
        return response()->json([
            'status' => 'success',
            'data' => PostTypeResource::make($postType),
        ]);
    }

    public function destroy(PostType $postType)
    {
        $postType->delete();
        return response()->noContent();
    }
}
