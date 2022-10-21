<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    return [
        'account' => $faker->name,
        'password' => 'ps123',
        'phone_no' => '0800092000'
    ];
});
