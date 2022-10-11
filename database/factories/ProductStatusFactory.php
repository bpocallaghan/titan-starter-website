<?php

namespace Database\Factories;

use App\Models\ProductCategory;
use App\Models\ProductFeature;
use App\Models\ProductStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductStatusFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductStatus::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'  => 'Example Name',
            'category' => 'Example Category',
            'slug' => 'example-slug',
        ];
    }
}
