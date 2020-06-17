<?php

use Illuminate\Database\Seeder;

class NewsletterSeeder extends Seeder
{
    const SEED_COUNT = 10;

    /**
     * @return void
     */
    public function run(): void
    {
        $newsletter = factory(App\Newsletter::class, self::SEED_COUNT)->create();
    }
}