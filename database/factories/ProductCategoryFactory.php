<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ProductCategory;
use Faker\Generator as Faker;

$factory->define(ProductCategory::class, function (Faker $faker) {
    return [
        'name'  => 'Example Category',
        'image' => 'image-1.png',
    ];
});
