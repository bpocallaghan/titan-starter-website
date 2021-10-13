<?php

namespace Database\Factories;

use App\Models\Banner;
use Illuminate\Database\Eloquent\Factories\Factory;

class BannerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Banner::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'        => 'Example Banner',
            'description' => $this->faker->sentence,
            'image'       => 'banner-1.jpg',
            'active_from' => now()->subWeek(),
            'active_to'   => now()->addWeek(),
        ];
    }
}
