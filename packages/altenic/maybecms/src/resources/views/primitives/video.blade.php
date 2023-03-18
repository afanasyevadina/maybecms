<div class="video-wrapper">
    @if($attachment = $block->attachments()->where('role', 'src')->first()?->file->assetPath)
        <video src="{{ $attachment->file->assetPath }}" poster="{{ $attachment->poster?->file->assetPath }}" class="video" controls preload="auto"></video>
    @endif
</div>
