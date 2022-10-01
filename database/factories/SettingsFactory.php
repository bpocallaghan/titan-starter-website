<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\Settings;
use Illuminate\Database\Eloquent\Factories\Factory;

class SettingsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Settings::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'        => 'Titan Starter',
            'description' => 'A Laravel Website with Admin access Starter project with AdminLTE theme and basic features.',
            'author'      => 'Ben-Piet O\'Callaghan',
            'keywords'    => 'cms, admin, titan, laravel, bpocallaghan',
        ];
    }
}
