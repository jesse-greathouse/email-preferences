<?php
 
use Faker\Generator as Faker;

use App\User;

$factory->define(User::class, function (Faker $faker) {
    return [
        'first_name'    => $faker->firstName,
        'last_name'     => $faker->lastName,
        'email'         => $faker->email,
    ];
});