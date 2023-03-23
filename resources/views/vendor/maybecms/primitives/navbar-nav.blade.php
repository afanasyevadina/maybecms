<div
    class="navbar-nav"
>
    @foreach($block->blocks as $childBlock)
        @if(view()->exists('maybecms::primitives.' . $childBlock->type))
            @include('maybecms::primitives.' . $childBlock->type, ['block' => $childBlock])
        @endif
    @endforeach
</div>
