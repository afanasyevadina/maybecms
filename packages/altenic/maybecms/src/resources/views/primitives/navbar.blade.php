<div
    class="navbar {{ $block->content['background'] ?? '' }}"
>
    <a href="/" class="navbar-brand">
        @if($attachment = $block->attachments()->where('role', 'logo')->first())
            <img src="{{ $attachment->file->assetPath }}" alt="{{ $block->content['text'] ?? 'logo' }}" class="navbar-logo">
        @endif
        <div class="navbar-title">{{ $block->content['text'] ?? '' }}</div>
    </a>
    @foreach($block->blocks as $childBlock)
        @if(view()->exists('maybecms::primitives.' . $childBlock->type))
            @include('maybecms::primitives.' . $childBlock->type, ['block' => $childBlock])
        @endif
    @endforeach
</div>
