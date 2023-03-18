@extends('maybecms::layouts.app')
@section('content')
    <div class="home">
        @foreach($page->blocks as $childBlock)
            @if(view()->exists('maybecms::primitives.' . $childBlock->type))
                @include('maybecms::primitives.' . $childBlock->type, ['block' => $childBlock])
            @endif
        @endforeach
    </div>
@endsection
