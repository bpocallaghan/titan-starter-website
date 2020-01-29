<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Banner;
use Faker\Generator as Faker;

$factory->define(Banner::class, function (Faker $faker) {
    return [
        'name'        => 'Example Banner',
        'description' => $faker->sentence,
        'image'       => 'banner-1.jpg',
        'active_from' => now()->subWeek(),
        'active_to'   => now()->addWeek(),
    ];
});
