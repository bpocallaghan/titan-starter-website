<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LayoutsTableSeeder extends BasicSeeder
{
    public function run()
    {
        $this->importBasic('layouts.csv', \App\Models\Layout::class);
        $this->importBasicTable('layout_template.csv', 'layout_template');
    }
}
