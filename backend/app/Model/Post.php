<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\PostComment;

class Post extends Model
{
    protected $table = 'post';
    protected $fillable = ['title', 'body'];

    public function comments()
    {
        return $this->hasMany(PostComment::class, 'post_id', 'id')->whereNull('comment_id');
    }
}
