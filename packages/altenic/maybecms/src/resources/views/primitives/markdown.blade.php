<div class="markdown">
    @if(@$block->query['text'])
        @if($block->query['text'] == 'title')
            {!! @$source?->title !!}
        @endif
        @if($block->query['text'] == 'description')
            {!! @$source?->description !!}
        @endif
        @if($fieldName = str_replace('field.', '', $block->query['text']))
            {!! @$source->content[$fieldName] !!}
        @endif
    @else
        {!! $block->content['text'] ?? '' !!}
    @endif
</div>
