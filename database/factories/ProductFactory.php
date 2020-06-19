<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Business;
use App\Models\Product;
use App\Models\ProductCategory;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => 'Product',
        'slug' => 'product',
        'reference' => '#123',
        'amount' => 50,
        'active_from' => now()->subDay(),
        'active_to' => null,
        'special_amount' => null,
        'special_from' => null,
        'special_to' => null,
        'available' => null,
        'content' => 'Description',
        'category_id' => factory(ProductCategory::class)->create(),
        'business_id' => factory(Business::class)->create(),
    ];
});
