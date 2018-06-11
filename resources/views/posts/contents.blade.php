@extends('layouts.app')

@section('title', 'content')

@section('content')

@if(session()->has('imessage'))
    <div class="alert alert-info mb-3">
        {{ session('imessage') }}
    </div>
@elseif(session()->has('umessage'))
    <div class="alert alert-info mb-3">
        {{ session('umessage') }}
    </div>
@endif

</h1>{{ $post->title }}</h1>
<p>{!! nl2br(e($post->content)) !!}</p>

<p>comment</p>

@foreach($comments as $comment)
    <p>{{ $comment->name }}</p>
    <p>{{ $comment->comment }}</p>
    <p>{{ $comment->created_at }}</p>
@endforeach

@if(Auth::check())
    {{ Form::open(['url' => 'comment', $post->id]) }}
        {{ Form::textarea('comment') }}
        {{ Form::submit('comment') }}
        <input type="hidden" name="post_id" value="{{ $post->id }}">
        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
    {{ Form::close() }}
@endif

{{ link_to_route('top', 'back') }}

@endsection
