<div class="video-wrapper">
    @if($attachment = $block->getAttachment('src', @$source))
        <video src="{{ $attachment?->file->assetPath }}" poster="{{ $attachment->poster?->file->assetPath }}" class="video" controls preload="auto"></video>
    @endif
</div>
