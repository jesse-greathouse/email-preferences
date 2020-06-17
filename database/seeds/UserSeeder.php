<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    const SEED_COUNT = 50;

    /**
     * @return void
     */
    public function run(): void
    {
        $user = factory(App\User::class, self::SEED_COUNT)->create();
    }
}