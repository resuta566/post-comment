<?php

namespace App\Http\Controllers;

use App\Model\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $post = Post::find(1);
        if(empty($post))
        {
            return response()->json('Not Found', 404);
        }
        return response()->json($post, 200);
    }

}
