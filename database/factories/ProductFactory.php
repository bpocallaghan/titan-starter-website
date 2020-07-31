<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Business;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductFeature;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'slug' => $faker->name,
        'reference' => $faker->numberBetween(100000, 999999),
        'amount' => 100,
        //'active_from' => now()->subDay(),
        //'active_to' => null,
        'special_amount' => null,
        'special_from' => null,
        'special_to' => null,
        'available' => null,
        'content' => $faker->sentence,
        'category_id' => factory(ProductCategory::class),
    ];
});

$factory->afterCreating(Product::class, function ($user, $faker) {
    $user->features()->save(factory(ProductFeature::class)->make());
});
