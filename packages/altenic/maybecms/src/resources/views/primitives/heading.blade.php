<{{ $block->getProperty('level') ?? 'h1' }} class="heading" style="{{ $block->getProperty('css') }}">
{!! nl2br($block->getProperty('text', @$source)) !!}
</{{ $block->getProperty('level') ?? 'h1' }}>
