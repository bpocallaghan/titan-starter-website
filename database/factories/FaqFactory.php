<?php

namespace Database\Factories;

use App\Models\FAQ;
use App\Models\FAQCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class FaqFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FAQ::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'question'    => 'Question',
            'answer'      => 'Answer',
            'category_id' => FAQCategory::factory()->create(),
        ];
    }
}
