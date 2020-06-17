<?php
 
use Faker\Generator as Faker;

use App\Subscription;

$factory->define(Subscription::class, function (Faker $faker) use ($factory) {
  return [
        'newsletter_id' => $factory->create(App\Newsletter::class)->id,
        'user_id'       => $factory->create(App\User::class)->id,
    ];
});