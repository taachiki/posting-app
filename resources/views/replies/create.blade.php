@extends('layouts.app')

@section('title', '返信作成')

@section('content')
<div class="container">
    <h1>返信作成</h1>
    <form method="POST" action="{{ route('replies.store', $post->id) }}">
        @csrf
        <div class="form-group">
            <label for="content">内容</label>
            <textarea name="content" id="content" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">返信を投稿</button>
        {{-- "一覧に戻る" ボタンを追加 --}}
        <a href="{{ route('posts.index') }}" class="btn btn-secondary">一覧に戻る</a>
    </form>
</div>
@endsection