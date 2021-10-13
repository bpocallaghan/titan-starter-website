<?php

namespace Database\Factories;

use App\Models\LogModelActivity;
use Illuminate\Database\Eloquent\Factories\Factory;

class LogModelActivityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LogModelActivity::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'subject_id'   => 1,
            'subject_type' => 'App\Models\User',
            'name'         => 'user_created',
            'before'       => 'before',
            'after'        => 'after',
            'user_id'      => 1,
        ];
    }
}
