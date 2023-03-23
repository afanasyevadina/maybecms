<?php

namespace Altenic\MaybeCms\Http\Controllers\Api;

use Altenic\MaybeCms\Http\Controllers\Controller;
use Altenic\MaybeCms\Http\Requests\BlockCreateRequest;
use Altenic\MaybeCms\Http\Resources\BlockResource;
use Altenic\MaybeCms\Models\Block;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class BlockController extends Controller
{
    /**
     * @param BlockCreateRequest $request
     * @return JsonResponse
     */
    public function store(BlockCreateRequest $request): JsonResponse
    {
        $block = Block::query()->create($request->safe()->except('post_type'));
        return BlockResource::make($block)->toResponse($request)->setStatusCode(201);
    }

    /**
     * @param Block $block
     * @return Response
     */
    public function destroy(Block $block): Response
    {
        $block->delete();
        return response()->noContent();
    }

    /**
     * @param Block $block
     * @return Response
     */
    public function clone(Block $block): Response
    {
        $block->attachable->appendBlocks([$block]);
        return response()->noContent(201);
    }
}
