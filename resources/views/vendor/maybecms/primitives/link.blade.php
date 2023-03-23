<a href="{{ $block->getProperty('url', @$source) }}" class="link {{ $block->getProperty('style') }}">
    {{ $block->getProperty('text', @$source) ?? $block->title }}
</a>
