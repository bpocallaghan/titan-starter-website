<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsTableSeeder extends Seeder
{
    public function run(\Faker\Generator $faker)
    {
        Settings::truncate();

        Settings::create([
            'name'        => 'Titan Starter',
            'description' => 'A Laravel Website with Admin access Starter project with AdminLTE theme and basic features.',
            'author'      => 'Ben-Piet O\'Callaghan',
            'keywords'    => 'cms, admin, titan, laravel, bpocallaghan',
            'email'       => 'hello@example.com',
            'telephone'   => '123456789',
            'cellphone'   => 'cellphone',
            'address'     => 'Example Address',
        ]);
    }
}
