@php
    $url = $block->content['url'] ?? '';
    if(@$block->query['url']) {
        if($block->query['url'] == 'link')
            $url = url('/' . $source->postType->slug . '/' . $source->slug);
        elseif($fieldName = str_replace('field.', '', $block->query['url']))
                  $url = @$source->content[$fieldName] ?? '';
    }
@endphp
<a href="{{ $url }}" class="link {{ $block->content['style'] ?? '' }}">
    {{ $block->content['text'] ?? $block->title }}
</a>
