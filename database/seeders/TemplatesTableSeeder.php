<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TemplatesTableSeeder extends BasicSeeder
{
    public function run()
    {
        $this->importBasic('templates.csv', \App\Models\Template::class);
    }
}
