<?php

namespace Altenic\MaybeCms\Http\Controllers;

use Altenic\MaybeCms\Models\Page;
use Altenic\MaybeCms\Models\Setting;

class PageController extends Controller
{
    public function index()
    {
        return view('maybecms::index', [
            'page' => Page::query()->findOrFail(Setting::query()->where('slug', 'home_page')->firstOrFail()->value),
        ]);
    }

    public function show(string $slug)
    {
        return view('maybecms::index', [
            'page' => Page::query()->where('slug', $slug)->firstOrFail(),
        ]);
    }
}
