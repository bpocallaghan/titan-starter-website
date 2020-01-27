<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Role;
use Faker\Generator as Faker;

$factory->define(Role::class, function (Faker $faker) {
    return [
        'name'    => 'Example Role',
        'slug'    => '/slug',
        'keyword' => 'example_role',
    ];
});
