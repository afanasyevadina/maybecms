<?php

namespace Altenic\MaybeCms\Http\Controllers\Api;

use Altenic\MaybeCms\Http\Controllers\Controller;
use Altenic\MaybeCms\Models\Block;

class PrimitiveController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => Block::PRIMITIVES,
        ]);
    }
}
