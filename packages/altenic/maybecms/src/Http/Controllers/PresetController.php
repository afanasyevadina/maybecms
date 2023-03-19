<?php

namespace Altenic\MaybeCms\Http\Controllers;

use Altenic\MaybeCms\Models\Preset;

class PresetController extends Controller
{
    public function show($id)
    {
        return view('maybecms::preset', [
            'preset' => Preset::query()->findOrFail($id),
        ]);
    }
}
