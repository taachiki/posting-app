<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // このモデルで代入を許可する属性
    protected $fillable = [
        'title',
        'content',
        'user_id',
    ];

    /**
     * この投稿に対する返信を取得します。
     */
    public function replies()
{
    return $this->hasMany(Reply::class);
}

    /**
     * この返信の親投稿を取得します。
     */
    public function parent()
    {
        return $this->belongsTo(Post::class, 'parent_id');
    }

    /**
     * この投稿を所有するユーザーを取得します。
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}