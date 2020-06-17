<?php

use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    const SEED_COUNT = 600;

    /**
     * @return void
     */
    public function run(): void
    {
        $subscription = factory(App\Subscription::class, self::SEED_COUNT)->create();
    }
}