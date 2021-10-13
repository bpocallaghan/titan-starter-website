<?php

namespace Database\Factories;

use App\Models\Navigation;
use Illuminate\Database\Eloquent\Factories\Factory;

class NavigationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Navigation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'icon'        => 'home',
            'name'        => 'Click Me',
            'slug'        => 'click-me',
            'description' => 'Lorem Ipsum',
            'url'         => '/click-me',
            'help_index_title'    => '',
            'help_index_content'  => '',
            'help_create_title'   => '',
            'help_create_content' => '',
            'help_edit_title'     => '',
            'help_edit_content'   => '',
            'list_order'          => 1,
            'is_hidden'           => 0,
            'parent_id'           => 0,
            'url_parent_id'       => 0,
            'created_by'          => 1,
            'updated_by'          => 1,
        ];
    }
}
