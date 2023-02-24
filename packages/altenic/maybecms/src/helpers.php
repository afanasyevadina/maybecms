<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

if(!function_exists('create_slug')) {
    function create_slug(Model $model, string $field = 'title', $separator = '-') : string
    {
        $model->slug = Str::slug($model[$field] ?? $model->id, $separator);
        $count = 0;
        while(get_class($model)::where('slug', $model->slug)->where('id', '<>', $model->id)->exists())
            $model->slug = Str::slug($model[$field] ?? $model->id, $separator) . $separator . ++$count;
        $model->save();
        return $model->slug;
    }
}
