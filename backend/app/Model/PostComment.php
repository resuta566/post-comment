<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use App\Model\Post;
use App\Model\PostComment;

class PostComment extends Model
{
    protected $table = 'post_comment';
    protected $fillable = ['post_id', 'comment_id', 'username', 'comment'];

    // protected $with = 'replies';

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function replies()
    {
        return $this->hasMany(PostComment::class, 'comment_id', 'id')->with('replies');
    }

    public function reply()
    {
        return $this->hasMany(PostComment::class, 'comment_id', 'id');
    }

    // Recursive Replies
    public function recursive() {
        $replies = $this->replies()->get();
        $flatReplies = array();

        foreach($replies as $index => $reply)
        {
            $r = $reply->toArray();
            $flatReplies[] = $r;
            if($reply->replies) {
                $children = $reply->recursive();
                $flatReplies[] = array_merge($flatReplies, $children);
            }
        }
        return $flatReplies;
    }

}
