<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Reply; // Replyモデルを使用するために追加
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReplyController extends Controller
{
    // Other methods...

    public function create(Post $post)
    {
        // Return the view for creating a reply, with the post object
        return view('replies.create', compact('post'));
    }

    // 返信を保存
    public function store(Request $request, Post $post)
{
    $request->validate([
        'content' => 'required|string',
    ]);

    $reply = new Reply();
    $reply->content = $request->input('content');
    $reply->user_id = Auth::id();
    $reply->post_id = $post->id; // ここを変更
    $reply->save();

    return redirect()->route('posts.show', $post->id)->with('flash_message', '返信が投稿されました。');
}
}