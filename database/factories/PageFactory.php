<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Navigation;
use Faker\Generator as Faker;

$factory->define(Page::class, function (Faker $faker) {
    return [
        'name'        => 'Click Me',

    ];
});
