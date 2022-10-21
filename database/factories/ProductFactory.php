<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    $choose = [
        'big',
        'small',
    ];
    $key = rand(0, 1);
    return [
        'size' => "$choose[$key]",
        'color' => $faker->colorName,
        'stock' => $faker->numberBetween(1, 50)
    ];
});
