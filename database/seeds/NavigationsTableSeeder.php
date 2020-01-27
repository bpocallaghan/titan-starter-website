<?php

class NavigationsTableSeeder extends BasicSeeder
{
    public function run()
    {
        $this->importBasic('navigations.csv', \App\Models\Navigation::class);
        $this->importBasicTable('navigation_role.csv', 'navigation_role');
        //$this->importBasic('navigation_website.csv', \App\Models\NavigationWebsite::class);
        //$this->importBasicTable('navigation_website_role.csv', 'navigation_website_role');
    }
}
