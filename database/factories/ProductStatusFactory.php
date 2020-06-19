<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ProductStatus;
use Faker\Generator as Faker;

$factory->define(ProductStatus::class, function (Faker $faker) {
    return [
        'name' => 'Example Status',
        'category' => 'primary',
    ];
});
