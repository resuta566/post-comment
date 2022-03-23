<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Model\Post;
use App\Model\PostComment;


class APITest extends TestCase
{
    use RefreshDatabase;
   
    public function test_show_post_test()
    {
        $post = factory(Post::class)->create();

        $response = $this->get('/api/post');

        $response->assertStatus(200);
    }

    public function test_show_post_comment_test()
    {
        $post = factory(Post::class)->create();

        $comment = factory(PostComment::class)->create();

        $response = $this->get('/api/post-comment/'. $post->id);

        $response->assertStatus(200);

    }

    public function test_post_comment_post_test()
    {
        $post = factory(Post::class)->create();
        $comment = [
            'post_id' => $post->id, 
            'comment_id'=> null, 
            'username'=> 'Test Username', 
            'comment'=> 'Test Comment'
        ];

        $response = $this->post('/api/post-comment/'.$post->id, $comment);

        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas(
            'post_comment',
            [
                'post_id' => $post->id, 
                'comment_id'=> $comment['comment_id'], 
                'username'=> $comment['username'], 
                'comment'=> $comment['comment']
            ]
        );

    }
}
