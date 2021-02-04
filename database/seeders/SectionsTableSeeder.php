<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SectionsTableSeeder extends BasicSeeder
{
    public function run()
    {
        $this->importBasic('sections.csv', \App\Models\Section::class);
    }
}
