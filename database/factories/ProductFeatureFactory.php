<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ProductFeature;
use Faker\Generator as Faker;

$factory->define(ProductFeature::class, function (Faker $faker) {
    return [
        'name' => 'Example Feature'
    ];
});
