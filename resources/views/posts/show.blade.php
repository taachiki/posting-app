@extends('layouts.app')

@section('title', '投稿詳細')

@section('content')
<div class="container mt-4">
    <h1>{{ $post->title }}</h1>
    <p>{{ $post->content }}</p>
    <p>投稿者: {{ $post->user->name }} - 投稿日時: {{ $post->created_at->format('Y-m-d H:i:s') }}</p>
    <p>返信数: {{ $post->replies->count() }}</p>

    <div class="mb-4">
        <a href="{{ route('replies.create', $post->id) }}" class="btn btn-primary">返信</a>
        {{-- "一覧に戻る" ボタンを追加 --}}
        <a href="{{ route('posts.index') }}" class="btn btn-secondary">一覧に戻る</a>
    </div>

    @foreach($post->replies as $reply)
        <div class="card mb-2">
            <div class="card-body">
                <p class="card-text">{{ $reply->content }}</p>
                <p class="card-subtitle mb-2 text-muted">投稿者: {{ $reply->user->name }} - 投稿日時: {{ $reply->created_at->format('Y-m-d H:i:s') }}</p>
            </div>
        </div>
    @endforeach
</div>
@endsection