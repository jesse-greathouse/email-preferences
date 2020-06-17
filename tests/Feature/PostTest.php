<?php

use App\Post;

class PostTest extends TestCase
{
    /**
     * get /post
     *
     * @return void
     */
    public function testGetPost()
    {
        $response = $this->getJson('/post');

        $response->assertStatus(200);
    }

    /**
     * post /post
     *
     * @return void
     */
    public function testPostPost()
    {
        $post = factory(Post::class)->make();

        $response = $this->json('POST', '/post', [
            'newsletter_id' => $post->newsletter->id,
            'publish_date'  => $post->publish_date,
            'content'       => $post->content
            ]);

        $response
            ->assertStatus(201)
            ->assertJsonStructure([
                'data',
                'meta' => [
                    'message',
                ]
            ]);
    }

    /**
     * get /post/{id}
     *
     * @return void
     */
    public function testGetPostById()
    {
        $post = factory(Post::class)->create();
        $response = $this->getJson('/post/'.$post->id);

        $response->assertStatus(200);
    }

    /**
     * put /post/{id}
     *
     * @return void
     */
    public function testPutPostById()
    {
        $post = factory(Post::class)->create();

        $response = $this->json('PUT', '/post/'.$post->id, [
          'newsletter_id' => $post->newsletter->id,
          'publish_date'  => $post->publish_date,
          'content'       => $post->content
          ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'meta' => [
                    'message',
                ]
            ]);
    }

    /**
     * delete /post/{id}
     *
     * @return void
     */
    public function testDeletePostById()
    {
        $post = factory(Post::class)->create();

        $response = $this->json('DELETE', '/post/'.$post->id);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'meta' => [
                    'message',
                ]
            ]);
    }
}