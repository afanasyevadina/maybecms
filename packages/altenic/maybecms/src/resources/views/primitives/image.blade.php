<div class="img-wrapper">
    @if($attachment = $block->attachments()->where('role', 'src')->first())
        <img class="img" src="{{ $attachment->file->assetPath }}"
             alt="{{ $block->content['alt'] ?? '' }}">
    @endif
</div>
