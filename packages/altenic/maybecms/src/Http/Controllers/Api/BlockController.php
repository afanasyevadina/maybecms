<?php

namespace Altenic\MaybeCms\Http\Controllers\Api;

use Altenic\MaybeCms\Http\Controllers\Controller;
use Altenic\MaybeCms\Http\Requests\BlockCreateRequest;
use Altenic\MaybeCms\Http\Requests\BlockUpdateRequest;
use Altenic\MaybeCms\Http\Resources\BlockResource;
use Altenic\MaybeCms\Models\Block;

class BlockController extends Controller
{
    public function store(BlockCreateRequest $request)
    {
        $block = Block::create($request->safe()->except('post_type'));
        return response()->json([
            'status' => 'success',
            'data' => BlockResource::make($block),
        ], 201);
    }

    public function update(Block $block, BlockUpdateRequest $request)
    {
        $block->update($request->validated());
        return response()->json([
            'status' => 'success',
            'data' => BlockResource::make($block),
        ]);
    }

    public function destroy(Block $block)
    {
        $block->delete();
        return response()->noContent();
    }
}
