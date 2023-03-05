<?php

namespace Altenic\MaybeCms\Http\Controllers\Api;

use Altenic\MaybeCms\Models\File;

trait Blockable
{
    private function updateBlocks($model, array $data): void
    {
        foreach ($data ?? [] as $item) {
            $block = $model->blocks()->findOrFail($item['id']);
            $block->update(collect($item)->only(['title', 'content', 'order'])->toArray());
            if (@$item['attachment']['file']['id']) {
                $attachment = $block->attachment()->updateOrCreate([], ['file_id' => File::query()->findOrFail($item['attachment']['file']['id'])->id]);
                if (@$item['attachment']['poster']['file']['id']) {
                    $attachment->poster()->updateOrCreate([], ['file_id' => File::query()->findOrFail($item['attachment']['poster']['file']['id'])->id, 'role' => 'poster']);
                } else {
                    $attachment->poster()->delete();
                }
            } else {
                $block->attachment()->delete();
            }
            $this->updateBlocks($block, $item['blocks'] ?? []);
        }
    }

    private function appendBlocks($attachable, $blocks): \Illuminate\Support\Collection
    {
        return collect($blocks ?? [])->map(function ($item) use ($attachable) {
            $childBlock = $attachable->blocks()->create([
                'type' => $item['type'] ?? '',
                'title' => $item['title'] ?? '',
                'content' => $item['content'] ?? [],
            ]);
            if ($item->type == 'section') $this->appendBlocks($childBlock, $item->blocks ?? []);
            return $childBlock;
        });
    }
}
