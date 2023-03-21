<div class="img-wrapper">
    @if($attachment = $block->getAttachment('src', @$source))
        <img class="img {{ $block->getProperty('shape') }}" src="{{ $attachment?->file->assetPath }}"
             alt="{{ $block->getProperty('alt') }}">
    @endif
</div>
