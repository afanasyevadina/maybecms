<?php

namespace Altenic\MaybeCms\Http\Controllers\Api;

use Altenic\MaybeCms\Http\Controllers\Controller;
use Altenic\MaybeCms\Models\Relation;

class RelationController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => Relation::TYPES,
        ]);
    }
}
