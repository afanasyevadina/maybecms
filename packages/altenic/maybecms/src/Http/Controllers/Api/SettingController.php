<?php

namespace Altenic\MaybeCms\Http\Controllers\Api;

use Altenic\MaybeCms\Http\Controllers\Controller;
use Altenic\MaybeCms\Http\Requests\SettingsUpdateRequest;
use Altenic\MaybeCms\Http\Resources\SettingsResource;
use Altenic\MaybeCms\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        return SettingsResource::collection(Setting::all());
    }

    public function update(SettingsUpdateRequest $request)
    {
        collect($request->input('settings'))->each(fn($setting) => Setting::query()->where('slug', $setting['slug'])->first()?->update(['value' => $setting['value']]));
        return response()->noContent(200);
    }
}
