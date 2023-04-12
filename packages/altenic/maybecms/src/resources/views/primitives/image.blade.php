<div class="img-wrapper">
    @if($attachment = $block->getAttachment('src', @$source))
        <img class="img {{ $block->getProperty('rounds') }}" style="{{ $block->getProperty('css') }}" src="{{ $attachment?->file->assetPath }}"
             alt="{{ $block->getProperty('alt') }}">
    @endif
</div>
