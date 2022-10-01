<?php

namespace Database\Factories;

use App\Models\ProductCategory;
use App\Models\ProductFeature;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFeatureFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductFeature::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'  => 'Example Category',
            'slug' => 'example-slug',
        ];
    }
}
