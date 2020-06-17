<?php
 
use Faker\Generator as Faker;

use App\Newsletter;

$factory->define(Newsletter::class, function (Faker $faker) {
  $numWords = rand(3, 6);
  $numDescWords = rand(3, 8);
  $words = $faker->words($numWords, false);
  $name = implode(' ', $words);
  $slug = implode('-', $words);
  return [
        'name'        => $name,
        'slug'        => $slug,
        'description' => $faker->words($numDescWords, true),
    ];
});