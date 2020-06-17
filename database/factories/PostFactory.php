<?php
 
use Faker\Generator as Faker;

use App\Post;

$factory->define(Post::class, function (Faker $faker) use ($factory) {
  $numSentences = rand(5, 20);
  return [
        'newsletter_id' => $factory->create(App\Newsletter::class)->id,
        'publish_date'  => $faker->dateTimeThisMonth,
        'content'       => $faker->paragraph($numSentences, true),
    ];
});