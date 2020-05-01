<?php

class PagesTableSeeder extends BasicSeeder
{
    public function run()
    {
        $this->importBasic('pages.csv', \App\Models\Page::class);
        //$this->importBasic('banner_page.csv', \App\Models\Navigation::class);
        //$this->importBasicTable('page_content.csv', 'navigation_role');
    }
}
