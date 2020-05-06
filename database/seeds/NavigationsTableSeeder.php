<?php

class NavigationsTableSeeder extends BasicSeeder
{
    public function run()
    {
        $this->importBasic('navigations.csv', \App\Models\Navigation::class);
        $this->importBasicTable('navigation_role.csv', 'navigation_role');
    }
}
