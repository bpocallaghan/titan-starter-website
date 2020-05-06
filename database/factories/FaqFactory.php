<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\FAQ;
use App\Models\FAQCategory;
use Faker\Generator as Faker;

$factory->define(FAQ::class, function (Faker $faker) {
    return [
        'question'    => 'Question',
        'answer'      => 'Answer',
        'category_id' => factory(FAQCategory::class)->create(),
    ];
});
