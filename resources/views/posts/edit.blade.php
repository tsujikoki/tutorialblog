@extends('layouts.app')

@section('title', 'edit')

@section('content')

{{ Form::open(['route' => ['posts.update', $post->id], 'method' => 'put']) }}
    <div>
        <p>title</p>
        {{ Form::text('title', $post->title) }}
    </div>
    <div>
        <p>content</p>
        {{ Form::textarea('content', $post->content) }}
    </div>
    {{ Form::submit('update') }}
{{ Form::close() }}

{{ link_to_route('top', 'back') }}

@endsection
