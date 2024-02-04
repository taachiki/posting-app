<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Http\Requests\PostRequest;

class PostController extends Controller
{
    // 投稿一覧を表示
    public function index()
    {
        $posts = Post::whereNull('parent_id')
            ->with('user')
            ->withCount('replies')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('posts.index', compact('posts'));
    }

    // 投稿詳細を表示
    public function show(Post $post)
    {
        $replies = Post::where('parent_id', $post->id)->get();
        $repliesCount = $replies->count(); // 返信の件数を取得

        return view('posts.show', compact('post', 'replies', 'repliesCount'));
    }

    // 投稿作成ページを表示
    public function create()
    {
        return view('posts.create');
    }

    // 新規投稿を保存
    public function store(PostRequest $request)
    {
        $post = new Post();
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->user_id = Auth::id();
        $post->save();

        return redirect()->route('posts.index')->with('flash_message', '投稿が完了しました。');
    }

    // 投稿編集ページを表示
    public function edit(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            return redirect()->route('posts.index')->with('error_message', '不正なアクセスです。');
        }

        return view('posts.edit', compact('post'));
    }

    // 投稿を更新
    public function update(PostRequest $request, Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            return redirect()->route('posts.index')->with('error_message', '不正なアクセスです。');
        }

        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->save();

        return redirect()->route('posts.show', $post)->with('flash_message', '投稿を編集しました。');
    }

    // 投稿を削除
    public function destroy(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            return redirect()->route('posts.index')->with('error_message', '不正なアクセスです。');
        }

        $post->delete();

        return redirect()->route('posts.index')->with('flash_message', '投稿を削除しました。');
    }

    // 返信を保存
    public function storeReply(Request $request, $postId)
    {
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        $reply = new Post();
        $reply->title = $request->input('title');
        $reply->content = $request->input('content');
        $reply->user_id = Auth::id();
        $reply->parent_id = $postId;
        $reply->save();

        return redirect()->route('posts.show', $postId)->with('flash_message', '返信が投稿されました。');
    }
}