<?php

namespace Altenic\MaybeCms\Http\Controllers\Api;

use Altenic\MaybeCms\Http\Controllers\Controller;
use Altenic\MaybeCms\Http\Requests\PageCreateRequest;
use Altenic\MaybeCms\Http\Requests\PageUpdateRequest;
use Altenic\MaybeCms\Http\Resources\PageListResource;
use Altenic\MaybeCms\Http\Resources\PageResource;
use Altenic\MaybeCms\Models\File;
use Altenic\MaybeCms\Models\Page;
use Altenic\MaybeCms\Models\Setting;

class PageController extends Controller
{
    use Blockable;

    public function index()
    {
        return PageListResource::collection(Page::query()->paginate(20));
    }

    public function home()
    {
        return PageResource::make(Page::query()->findOrFail(Setting::query()->where('slug', 'home_page')->firstOrFail()->value));
    }

    public function show($pageId)
    {
        return PageResource::make(Page::query()->where('id', $pageId)->orWhere('slug', $pageId)->firstOrFail());
    }

    public function store(PageCreateRequest $request)
    {
        $page = Page::query()->create($request->validated());
        return response()->json([
            'status' => 'success',
            'data' => PageResource::make($page),
        ], 201);
    }

    public function update(Page $page, PageUpdateRequest $request)
    {
        $page->update($request->safe()->except(['blocks', 'meta']));
        $meta = $page->meta()->updateOrCreate([], collect($request->input('meta'))->only(['title', 'description'])->toArray());
        if ($request->input('meta.attachment.file.id')) {
            $meta->attachment()->updateOrCreate([], ['file_id' => File::query()->findOrFail($request->input('meta.attachment.file.id'))->id]);
        } else {
            $meta->attachment()->delete();
        }
        $this->updateBlocks($page, $request->input('blocks') ?? []);
        return response()->json([
            'status' => 'success',
            'data' => PageResource::make($page),
        ]);
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return response()->noContent();
    }
}
