<?php

use App\Subscription;

class SubscriptionTest extends TestCase
{
    /**
     * get /subscription
     *
     * @return void
     */
    public function testGetSubscription()
    {
        $response = $this->getJson('/subscription');

        $response->assertStatus(200);
    }

    /**
     * post /subscription
     *
     * @return void
     */
    public function testSubscriptionSubscription()
    {
        $subscription = factory(Subscription::class)->make();

        $response = $this->json('POST', '/subscription', [
            'user_id' => $subscription->user->id,
            'newsletter_id'  => $subscription->newsletter->id
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
     * get /subscription/{id}
     *
     * @return void
     */
    public function testGetSubscriptionById()
    {
        $subscription = factory(Subscription::class)->create();
        $response = $this->getJson('/subscription/'.$subscription->id);

        $response->assertStatus(200);
    }

    /**
     * put /subscription/{id}
     *
     * @return void
     */
    public function testPutSubscriptionById()
    {
        $subscription = factory(Subscription::class)->create();

        $response = $this->json('PUT', '/subscription/'.$subscription->id, [
          'user_id' => $subscription->user->id,
          'newsletter_id'  => $subscription->newsletter->id
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
     * delete /subscription/{id}
     *
     * @return void
     */
    public function testDeleteSubscriptionById()
    {
        $subscription = factory(Subscription::class)->create();

        $response = $this->json('DELETE', '/subscription/'.$subscription->id);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'meta' => [
                    'message',
                ]
            ]);
    }
}