<?php

namespace App\Http\Controllers;

use App\Model\Post;
use Illuminate\Http\Request;

class PostCommentController extends Controller
{    
    public function show(Post $post)
    {
        $postComments = $post->comments();
        $postCounter = $post->comments()->count();

        $max_depth = 3;
        $firstDepthComments = $post->comments()
            ->whereNull('comment_id')
            ->with('replies')
            ->latest()
            ->get();
            
        

        return response()->json($firstDepthComments, 200);
    }

    public function store(Post $post, Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'comment' => 'required|min:5'
        ]);

        // dd($request->comment_id );

        $newComment = $post->comments()->create([
            'comment_id' => $request->comment_id,
            'username' => $request->username,
            'comment' => $request->comment
        ]);

        return response($newComment, 200);
    }    
}
