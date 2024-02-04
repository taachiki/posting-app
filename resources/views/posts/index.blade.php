@extends('layouts.app')

@section('title', '投稿一覧')

@section('content')
    @if (session('flash_message'))
        <p class="text-success">{{ session('flash_message') }}</p>
    @endif

    @if (session('error_message'))
        <p class="text-danger">{{ session('error_message') }}</p>
    @endif

    <div class="mb-2">
        <a href="{{ route('posts.create') }}" class="text-decoration-none">新規投稿</a>
    </div>

    @if($posts->isNotEmpty())
        @foreach($posts as $post)
            <article>
                <div class="card mb-3">
                    <div class="card-body">
                        <h2 class="card-title fs-5">{{ $post->title }}</h2>
                        <p class="card-text">{{ $post->content }}</p>
                        <small class="text-muted">投稿者: {{ $post->user->name }} - 投稿日時: {{ $post->created_at->format('Y-m-d H:i:s') }}</small>
                        {{-- 返信の件数を表示 --}}
                        <small class="text-muted reply-count">返信数: {{ $post->replies_count }}</small>

                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <a href="{{ route('posts.show', $post) }}" class="btn btn-outline-primary">詳細</a>
                            @if ($post->user_id === Auth::id())
                                <div>
                                    <a href="{{ route('posts.edit', $post) }}" class="btn btn-outline-secondary">編集</a>
                                    <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('本当に削除してもよろしいですか？');" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger">削除</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </article>
        @endforeach
    @else
        <p>投稿はありません。</p>
    @endif
@endsection