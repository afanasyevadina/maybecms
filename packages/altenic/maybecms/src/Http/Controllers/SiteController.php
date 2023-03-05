<?php

namespace Altenic\MaybeCms\Http\Controllers;

use Altenic\MaybeCms\Http\Resources\PageResource;
use Altenic\MaybeCms\Models\Page;
use Altenic\MaybeCms\Models\Setting;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index(Request $request)
    {
        $page = Page::query()->findOrNew(Setting::query()->where('slug', 'home_page')->first()?->value);
        return view('maybecms::site.page', [
            'page' => json_decode(PageResource::make($page)->toJson(), true),
        ]);
    }

    public function page(string $slug)
    {
        //
    }
}
