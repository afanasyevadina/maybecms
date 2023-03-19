<?php

namespace Altenic\MaybeCms\Http\Controllers;

use Altenic\MaybeCms\Models\Post;
use Illuminate\Database\Eloquent\Builder;

class PostController extends Controller
{
    public function show(string $postType, string $slug)
    {
        return view('maybecms::post', [
            'post' => Post::query()->where('slug', $slug)->whereHas('postType', fn(Builder $query) => $query->where('slug', $postType))->firstOrFail(),
        ]);
    }
}
