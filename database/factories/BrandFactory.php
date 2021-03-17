<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Brand as BrandModle;

use Faker\Generator as Faker;

$factory->define(BrandModle::class, function (Faker $faker) {
    return [
        'name' => $faker->word(),
        'is_active' => $faker->boolean(),

    ];
});
