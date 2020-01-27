<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\Bpocallaghan\LogActivity\Models\LogModelActivity::class, function (Faker $faker) {
    return [
        'subject_id'   => 1,
        'subject_type' => 'App\User',
        'name'         => 'user_created',
        'before'       => 'before',
        'after'        => 'after',
        'user_id'      => 1,
    ];
});
