<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Post;
use App\Model\PostComment;

class PostComment extends Model
{
    protected $table = 'post_comment';
    protected $fillable = ['post_id', 'comment_id', 'username', 'comment'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function replies()
    {
        return $this->hasMany(PostComment::class, 'comment_id', 'id');
    }

}
