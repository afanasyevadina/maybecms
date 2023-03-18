<?php

namespace Altenic\MaybeCms\Http\Controllers\Api;

use Altenic\MaybeCms\Http\Controllers\Controller;

class RelationTypeController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => maybe_relation_types(),
        ]);
    }
}
