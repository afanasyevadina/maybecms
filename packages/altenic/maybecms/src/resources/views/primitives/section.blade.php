@if($block->postType()->exists())
    @foreach($block->postType?->posts as $post)
        <div
            class="section {{ $block->content['background'] ?? '' }} {{ $block->content['width'] ?? '' }} {{ $block->content['display'] ?? '' }} {{ $block->content['align-v'] ?? '' }} {{ $block->content['align-h'] ?? '' }}"
            style="{{ $block->content['css']?? '' }}"
        >
            @foreach($block->blocks as $childBlock)
                @if(view()->exists('maybecms::primitives.' . $childBlock->type))
                    @include('maybecms::primitives.' . $childBlock->type, ['block' => $childBlock, 'source' => $post])
                @endif
            @endforeach
        </div>
    @endforeach
    @else
    <div
        class="section {{ $block->content['background'] ?? '' }} {{ $block->content['width'] ?? '' }} {{ $block->content['display'] ?? '' }} {{ $block->content['align-v'] ?? '' }} {{ $block->content['align-h'] ?? '' }}"
        style="{{ $block->content['css']?? '' }}"
    >
        @foreach($block->blocks as $childBlock)
            @if(view()->exists('maybecms::primitives.' . $childBlock->type))
                @include('maybecms::primitives.' . $childBlock->type, ['block' => $childBlock, 'source' => @$source])
            @endif
        @endforeach
    </div>
@endif
