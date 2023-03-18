<?php

namespace Altenic\MaybeCms\Http\Controllers\Api;

use Altenic\MaybeCms\Models\Block;
use Altenic\MaybeCms\Models\File;

trait Blockable
{
    private function updateBlocks($model, array $data): void
    {
        foreach ($data ?? [] as $item) {
            $block = $model->blocks()->findOrFail($item['id']);
            $dataToUpdate = collect($item)->only(['title', 'order', 'post_type_id'])->toArray();
            $attachmentIds = [];
            foreach($item['content'] ?? [] as $contentItem) {
                $dataToUpdate['content'][$contentItem['slug']] = $contentItem['value'];
                if (@$contentItem['attachment']['file']['id']) {
                    $attachment = $block->attachments()->updateOrCreate(['role' => $contentItem['slug']], ['file_id' => File::query()->findOrFail($contentItem['attachment']['file']['id'])->id]);
                    if (@$contentItem['attachment']['poster']['file']['id']) {
                        $attachment->poster()->updateOrCreate([], ['file_id' => File::query()->findOrFail($contentItem['attachment']['poster']['file']['id'])->id, 'role' => 'poster']);
                    } else {
                        $attachment->poster()->delete();
                    }
                    $attachmentIds[] = $attachment->id;
                }
            }
            foreach ($block->attachments()->whereNotIn('id', $attachmentIds)->get() as $unusedAttachment) {
                $unusedAttachment->delete();
            }
            $block->update($dataToUpdate);
//            if (@$item['attachment']['file']['id']) {
//                $attachment = $block->attachment()->updateOrCreate([], ['file_id' => File::query()->findOrFail($item['attachment']['file']['id'])->id]);
//                if (@$item['attachment']['poster']['file']['id']) {
//                    $attachment->poster()->updateOrCreate([], ['file_id' => File::query()->findOrFail($item['attachment']['poster']['file']['id'])->id, 'role' => 'poster']);
//                } else {
//                    $attachment->poster()->delete();
//                }
//            } else {
//                $block->attachment()->delete();
//            }
            $this->updateBlocks($block, $item['blocks'] ?? []);
        }
    }

    private function appendBlocks($attachable, $blocks): \Illuminate\Support\Collection
    {
        return collect($blocks ?? [])->map(function (Block $item) use ($attachable) {
            $childBlock = $attachable->blocks()->create([
                'type' => $item->type ?? '',
                'title' => $item->title ?? '',
                'content' => $item->content ?? [],
                'post_type_id' => $item->post_type_id ?? [],
            ]);
            if ($attachment = $item->attachment()->first()) {
                $childBlock->attachment()->create([
                    'file_id' => $attachment->file_id,
                    'role' => $attachment->role,
                    'alt' => $attachment->alt,
                ]);
            }
            $this->appendBlocks($childBlock, $item->blocks ?? []);
            return $childBlock;
        });
    }
}
