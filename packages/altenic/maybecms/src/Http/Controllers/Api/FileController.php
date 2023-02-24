<?php

namespace Altenic\MaybeCms\Http\Controllers\Api;

use Altenic\MaybeCms\Http\Controllers\Controller;
use Altenic\MaybeCms\Http\Requests\FileCreateRequest;
use Altenic\MaybeCms\Http\Resources\FileResource;
use Altenic\MaybeCms\Models\File;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function index(Request $request)
    {
        return FileResource::collection(File::query()->where('type', $request->input('type'))->latest()->paginate(50));
    }

    public function store(FileCreateRequest $request)
    {
        $file = File::create($request->safe()->except('file'));
        return response()->json([
            'status' => 'success',
            'data' => FileResource::make($file),
        ], 201);
    }

    public function show(File $file)
    {
        return FileResource::make($file);
    }

    public function destroy(File $file)
    {
        $file->delete();
        return response()->noContent();
    }
}
