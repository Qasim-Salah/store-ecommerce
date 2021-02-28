<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use App\Models\Category as CategoryModel;
use Faker\Generator as Faker;


    $factory->define(CategoryModel::class, function (Faker $faker) {
        return [
            'name' => $faker->word(),
            'slug' => $faker->slug(),
            'is_active' => $faker->boolean(),

        ];
});
