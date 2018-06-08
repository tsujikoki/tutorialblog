@extends('layouts.app')

@section('title', 'index')

@section('content')

{{-- {{ Form::open(['route' => 'posts.show']) }}
    {{ Form::text('title', $post->title) }}
    {{ Form::submit('Search') }}
{{ Form::close() }} --}}

@if(session()->has('dmessage'))
    <div class="alert alert-info mb-3">
        {{session('dmessage')}}
    </div>
@endif

<table>
<tr>
    <th>title</th>
    <th>created_at</th>
</tr>
@foreach ($posts as $post)
<tr>
    <td>{{ link_to_route('posts.show', $post->title, [$post->id]) }}</td>
    <td>{{ $post->created_at }}</td>
    {{-- ログイン済みユーザーのみ表示 --}}
    @if(Auth::check())
        <td>
            {{ link_to_route('posts.edit', 'edit', [$post->id]) }}
        </td>
        <td>
            {{ Form::open(['route' => ['posts.destroy', $post->id], 'method' => 'delete']) }}
                {{ Form::submit('delete') }}
            {{ Form::close() }}
        </td>
    @endif
</tr>
@endforeach
</table>
@if(Auth::check())
    <a href = "{{ action('PostsController@create') }}">new post</a>
    {{-- {{ Form::open(['route' => 'posts.create']) }}
        { Form::submit('new post') }}
    {{ Form::close() }} --}}
@endif
@endsection
