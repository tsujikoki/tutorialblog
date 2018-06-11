@extends('layouts.app')

@section('title', 'index')

@section('content')


{{ Form::open(['route' => 'posts.index', 'method' => 'get']) }}
    Keywords:{{ Form::text('keywords') }}
    {{ Form::submit('Search') }}
{{ Form::close() }}
<br>
{{ Form::open(['route' => 'posts.index', 'method' => 'get']) }}
    FromDate:{{ Form::text('fromdate') }}
    ToDate:{{ Form::text('todate') }}
    {{ Form::submit('Search') }}
{{ Form::close() }}

{{-- 削除実行時表示 --}}
@if(session()->has('dmessage'))
    <div class="alert alert-info mb-3">
        {{ session('dmessage') }}
    </div>
@endif
<br>

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
    {{ link_to_route('posts.create', 'new post') }}
@endif

{{ $posts->appends(request()->input())->links() }}
@endsection
