<?php

use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'code' => $faker->randomElement($array = ['G', 'C']) . $faker->randomNumber(7),
        'name' => $faker->name,
        'price' => $faker->randomNumber(5),
		'qty' => $faker->randomNumber(2),
    ];
});
