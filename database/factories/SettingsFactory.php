<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Role;
use Faker\Generator as Faker;

$factory->define(\App\Models\Settings::class, function (Faker $faker) {
    return [
        'name'        => 'Titan Starter',
        'description' => 'A Laravel Website with Admin access Starter project with AdminLTE theme and basic features.',
        'author'      => 'Ben-Piet O\'Callaghan',
        'keywords'    => 'cms, admin, titan, laravel, bpocallaghan',
    ];
});
