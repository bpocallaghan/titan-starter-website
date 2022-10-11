<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'slug' =>  $this->faker->name,
            'reference' =>  $this->faker->numberBetween(100000, 999999),
            'amount' => 100,
            //'active_from' => now()->subDay(),
            //'active_to' => null,
            'special_amount' => null,
            'special_from' => null,
            'special_to' => null,
            'available' => null,
            'content' =>  $this->faker->sentence,
            'category_id' => ProductCategory::factory()->create()->id,
        ];
    }

//$factory->afterCreating(Product::class, function ($user, $faker) {
//    $user->features()->save(factory(ProductFeature::class)->make());
//});
}
