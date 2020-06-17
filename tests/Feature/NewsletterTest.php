<?php

use App\Newsletter;

class NewsletterTest extends TestCase
{
    /**
     * get /newsletter
     *
     * @return void
     */
    public function testGetNewsletter()
    {
        $response = $this->getJson('/newsletter');

        $response->assertStatus(200);
    }

    /**
     * post /newsletter
     *
     * @return void
     */
    public function testPostNewsletter()
    {
        $newsletter = factory(Newsletter::class)->make();

        $response = $this->json('POST', '/newsletter', [
            'name'        => $newsletter->name,
            'slug'        => $newsletter->slug,
            'description' => $newsletter->description
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
     * get /newsletter/{id}
     *
     * @return void
     */
    public function testGetNewsletterById()
    {
        $newsletter = factory(Newsletter::class)->create();
        $response = $this->getJson('/newsletter/'.$newsletter->id);

        $response->assertStatus(200);
    }

    /**
     * put /newsletter/{id}
     *
     * @return void
     */
    public function testPutNewsletterById()
    {
        $newsletter = factory(Newsletter::class)->create();

        $response = $this->json('PUT', '/newsletter/'.$newsletter->id, [
            'name'        => $newsletter->name,
            'slug'        => $newsletter->slug,
            'description' => $newsletter->description
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
     * delete /newsletter/{id}
     *
     * @return void
     */
    public function testDeleteNewsletterById()
    {
        $newsletter = factory(Newsletter::class)->create();

        $response = $this->json('DELETE', '/newsletter/'.$newsletter->id);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'meta' => [
                    'message',
                ]
            ]);
    }
}