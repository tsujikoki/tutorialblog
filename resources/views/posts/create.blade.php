@extends('layouts.app')

@section('title', 'create')

@section('content')

<h1>create post</h1>

{{ Form::open(['route' => 'posts.store']) }}
    <div>
        <p>title</p>
        {{ Form::text('title', $post->title) }}
    </div>
    <div>
        <p>content</p>
        {{ Form::textarea('content', $post->content) }}
    </div>
    {{ Form::submit('create') }}
{{ Form::close() }}

{{-- エラーメッセージを表示 --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@endsection
