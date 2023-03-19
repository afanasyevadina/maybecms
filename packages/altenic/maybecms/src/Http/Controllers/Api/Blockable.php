<?php

namespace Altenic\MaybeCms\Http\Controllers\Api;

use Altenic\MaybeCms\Models\Block;
use Altenic\MaybeCms\Models\File;
use Illuminate\Support\Collection;

trait Blockable
{
    private function updateBlocks($model, array $data): void
    {
        foreach ($data ?? [] as $item) {
            $block = $model->blocks()->findOrFail($item['id']);
            $this->updateContent($block, collect($item)->only(['title', 'order', 'post_type_id', 'content'])->toArray());
            $this->updateBlocks($block, $item['blocks'] ?? []);
        }
    }

    private function appendBlocks($attachable, $blocks): Collection
    {
        return collect($blocks ?? [])->map(function (Block $item) use ($attachable) {
            $childBlock = $attachable->blocks()->create([
                'type' => $item->type ?? '',
                'title' => $item->title ?? '',
                'content' => $item->content ?? [],
                'post_type_id' => $item->post_type_id,
            ]);
            foreach ($item->attachments as $attachment) {
                $childBlock->attachments()->create([
                    'file_id' => $attachment->file_id,
                    'role' => $attachment->role,
                    'alt' => $attachment->alt,
                ]);
            }
            $this->appendBlocks($childBlock, $item->blocks ?? []);
            return $childBlock;
        });
    }

    private function updateContent($model, array $data)
    {
        $attachmentIds = [];
        foreach($data['content'] as $contentItem) {
            if (@$contentItem['attachment']['file']['id']) {
                $attachment = $model->attachments()->updateOrCreate(['role' => $contentItem['slug']], ['file_id' => File::query()->findOrFail($contentItem['attachment']['file']['id'])->id]);
                if (@$contentItem['attachment']['poster']['file']['id']) {
                    $attachment->poster()->updateOrCreate([], ['file_id' => File::query()->findOrFail($contentItem['attachment']['poster']['file']['id'])->id, 'role' => 'poster']);
                } else {
                    $attachment->poster()->delete();
                }
                $attachmentIds[] = $attachment->id;
            }
        }
        foreach ($model->attachments()->whereNotIn('id', $attachmentIds)->get() as $unusedAttachment) {
            $unusedAttachment->delete();
        }
        $data['content'] = collect($data['content'] ?? [])->map(fn($item) => [$item['slug'] => $item['value'] ?? ''])->collapse();
        $model->update($data);
    }
}
