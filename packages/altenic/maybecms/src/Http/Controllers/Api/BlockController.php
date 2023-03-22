<?php

namespace Altenic\MaybeCms\Http\Controllers\Api;

use Altenic\MaybeCms\Http\Controllers\Controller;
use Altenic\MaybeCms\Http\Requests\BlockCreateRequest;
use Altenic\MaybeCms\Http\Resources\BlockResource;
use Altenic\MaybeCms\Models\Block;

class BlockController extends Controller
{
    public function store(BlockCreateRequest $request)
    {
        $block = Block::create($request->safe()->except('post_type'));
        return (new BlockResource($block))->toResponse($request)->setStatusCode(201);
    }

    public function destroy(Block $block)
    {
        $block->delete();
        return response()->noContent();
    }

    public function clone(Block $block)
    {
        $block->attachable->appendBlocks([$block]);
        return response()->noContent(201);
    }
}
