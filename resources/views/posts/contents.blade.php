@extends('layouts.app')

@section('title', 'content')

@section('content')

@if(session()->has('imessage'))
    <div class="alert alert-info mb-3">
        {{session('imessage')}}
    </div>
@elseif(session()->has('umessage'))
    <div class="alert alert-info mb-3">
        {{session('umessage')}}
    </div>
@endif

</h1>{{ $post->title }}</h1>
<p>{!! nl2br(e($post->content)) !!}</p>

{{-- <a href = "{{ action('PostsController@index')}}">back</a> --}}
{{ link_to_route('top', 'back') }}

@endsection
