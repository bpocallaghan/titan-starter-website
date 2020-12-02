<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;

class PagesTableSeeder extends BasicSeeder
{
    public function run()
    {
        $this->importBasic('pages.csv', Page::class);
        //$this->importBasicTable('banner_page.csv', 'banner_page');
        //$this->importBasicTable('page_content.csv', 'page_content');
    }
}
