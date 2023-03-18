<?php

use Altenic\MaybeCms\Models\Block;
use Altenic\MaybeCms\Models\Meta;
use Altenic\MaybeCms\Models\Page;
use Altenic\MaybeCms\Models\Post;
use Altenic\MaybeCms\Models\Preset;
use Altenic\MaybeCms\Models\Setting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

if(!function_exists('create_slug')) {
    /**
     * @param Model $model
     * @param string $field
     * @param $separator
     * @return string
     */
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

if(!function_exists('maybe_field_types')) {
    /**
     * @return array
     */
    function maybe_field_types() : array
    {
        return config('maybecms.field_types', []);
    }
}

if(!function_exists('maybe_primitives')) {
    /**
     * @return array
     */
    function maybe_primitives() : array
    {
        return config('maybecms.primitives', []) + config(maybe_setting('active_theme') . '.primitives', []);
    }
}

if(!function_exists('maybe_setting')) {
    /**
     * @param string $setting
     * @param $default
     * @return string
     */
    function maybe_setting(string $setting, $default = '') : string
    {
        return Setting::query()->where('slug', $setting)->first()?->value ?? $default;
    }
}

if(!function_exists('maybe_attachable_class')) {
    /**
     * @param string|null $attachableType
     * @return string
     */
    function maybe_attachable_class(?string $attachableType) : string
    {
        return match ($attachableType) {
            'page' => Page::class,
            'post' => Post::class,
            'preset' => Preset::class,
            'meta' => Meta::class,
            default => Block::class,
        };
    }
}
