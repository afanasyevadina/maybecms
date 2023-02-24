<?php

namespace Altenic\MaybeCms\Http\Controllers\Api;

use Altenic\MaybeCms\Http\Controllers\Controller;
use Altenic\MaybeCms\Http\Requests\PresetApplyRequest;
use Altenic\MaybeCms\Http\Requests\PresetCreateRequest;
use Altenic\MaybeCms\Http\Requests\PresetUpdateRequest;
use Altenic\MaybeCms\Http\Resources\BlockResource;
use Altenic\MaybeCms\Http\Resources\PresetResource;
use Altenic\MaybeCms\Models\Preset;

class PresetController extends Controller
{
    public function index()
    {
        return PresetResource::collection(Preset::all());
    }

    public function show(Preset $preset)
    {
        return PresetResource::make($preset);
    }

    public function store(PresetCreateRequest $request)
    {
        $preset = Preset::create($request->validated());
        return response()->json([
            'status' => 'success',
            'data' => PresetResource::make($preset),
        ], 201);
    }

    public function update(Preset $preset, PresetUpdateRequest $request)
    {
        $preset->update($request->validated());
        return response()->json([
            'status' => 'success',
            'data' => PresetResource::make($preset),
        ]);
    }

    public function apply(Preset $preset, PresetApplyRequest $request)
    {
        $className = $request->input('attachable_type');
        $attachable = $className::find($request->input('attachable_id'));
        return response()->json([
            'status' => 'success',
            'data' => BlockResource::collection($this->appendBlocks($attachable, $preset->blocks)),
        ], 201);
    }

    public function destroy(Preset $preset)
    {
        $preset->delete();
        return response()->noContent();
    }

    private function appendBlocks($attachable, $blocks): \Illuminate\Support\Collection
    {
        return collect($blocks ?? [])->map(function ($item) use ($attachable) {
            $childBlock = $attachable->blocks()->create([
                'type' => $item['type'] ?? '',
                'title' => $item['title'] ?? '',
            ]);
            if ($item['type'] == 'section') $this->appendBlocks($childBlock, $item['blocks'] ?? []);
            return $childBlock;
        });
    }
}
