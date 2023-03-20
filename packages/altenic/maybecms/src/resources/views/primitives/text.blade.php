<div class="text">
    @if(@$block->query['text'])
        @if($block->query['text'] == 'title')
            {!! @$source?->title !!}
        @endif
        @if($block->query['text'] == 'description')
            {!! @$source?->description !!}
        @endif
        @if($fieldName = str_replace('field.', '', $block->query['text']))
            {!! nl2br(@$source->content[$fieldName]) !!}
        @endif
    @else
        {!! nl2br($block->content['text'] ?? '') !!}
    @endif
</div>
