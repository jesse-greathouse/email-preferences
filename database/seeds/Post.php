<?php

use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    const SEED_COUNT = 200;

    /**
     * @return void
     */
    public function run(): void
    {
        $post = factory(App\Post::class, self::SEED_COUNT)->create();
    }
}