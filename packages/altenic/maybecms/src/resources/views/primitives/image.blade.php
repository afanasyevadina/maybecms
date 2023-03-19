@php
    $attachment = $block->attachments()->where('role', 'src')->first();
    if($fieldName = str_replace('field.', '', $block->query['src'] ?? ''))
        $attachment = $source->attachments()->where('role', $fieldName)->first();
@endphp
<div class="img-wrapper">
    @if($attachment)
        <img class="img {{ $block->content['shape'] ?? '' }}" src="{{ $attachment->file->assetPath }}"
             alt="{{ $block->content['alt'] ?? '' }}">
    @endif
</div>
