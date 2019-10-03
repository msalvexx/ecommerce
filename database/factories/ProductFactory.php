<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name'              => $faker->word,
        'product_type_id'   => $faker->numberBetween(1, 10),
        'brand'  => $faker->word,
        'amount' => $faker->randomFloat(2, 1, 2000),
        'stock'  => $faker->randomNumber(3)
    ];
});
