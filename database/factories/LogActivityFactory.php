<?php

namespace Database\Factories;

use Bpocallaghan\LogActivity\Models\LogActivity;
use Illuminate\Database\Eloquent\Factories\Factory;

class LogActivityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LogActivity::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'        => $this->faker->name,
            'description' => $this->faker->sentence,
        ];
    }
}
