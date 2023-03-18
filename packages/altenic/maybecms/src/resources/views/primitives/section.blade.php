<div class="section {{ $block->content['background'] ?? '' }} {{ $block->content['width'] ?? '' }} {{ $block->content['display'] ?? '' }}">
    @foreach($block->blocks as $childBlock)
        @if(view()->exists('maybecms::primitives.' . $childBlock->type))
            @include('maybecms::primitives.' . $childBlock->type, ['block' => $childBlock])
        @endif
    @endforeach
</div>
