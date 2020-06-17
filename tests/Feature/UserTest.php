<?php

use App\User;

class UserTest extends TestCase
{
    /**
     * get /user
     *
     * @return void
     */
    public function testGetUser()
    {
        $response = $this->getJson('/user');

        $response->assertStatus(200);
    }

    /**
     * post /user
     *
     * @return void
     */
    public function testPostUser()
    {
        $user = factory(User::class)->make();

        $response = $this->json('POST', '/user', [
            'first_name'    => $user->first_name,
            'last_name'     => $user->last_name,
            'email'         => $user->email
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
     * get /user/{id}
     *
     * @return void
     */
    public function testGetUserById()
    {
        $user = factory(User::class)->create();
        $response = $this->getJson('/user/'.$user->id);

        $response->assertStatus(200);
    }

    /**
     * put /user/{id}
     *
     * @return void
     */
    public function testPutUserById()
    {
        $user = factory(User::class)->create();

        $response = $this->json('PUT', '/user/'.$user->id, [
            'first_name'    => $user->first_name,
            'last_name'     => $user->last_name,
            'email'         => $user->email
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
     * delete /user/{id}
     *
     * @return void
     */
    public function testDeleteUserById()
    {
        $user = factory(User::class)->create();

        $response = $this->json('DELETE', '/user/'.$user->id);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'meta' => [
                    'message',
                ]
            ]);
    }
}