<?php

namespace App\Http\Controllers;

use App\Model\Post;
use Illuminate\Http\Request;

class PostCommentController extends Controller
{    
    // 
    public function show(Post $post)
    {
        // Get All the parents comments
        $postComments = $post->comments()
            ->whereNull('comment_id')
            ->with('replies')
            ->latest()
            ->get();

        return response()->json($firstDepthComments, 200);
    }

    public function store(Post $post, Request $request)
    {
        // Validate
        $this->validate($request, [
            'username' => 'required',
            'comment' => 'required|min:5'
        ]);

        // Create New Comment
        $newComment = $post->comments()->create([
            'comment_id' => $request->comment_id,
            'username' => $request->username,
            'comment' => $request->comment
        ]);

        // Return the success comment
        return response($newComment, 200);
    }    
}
