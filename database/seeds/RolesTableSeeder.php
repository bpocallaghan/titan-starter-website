<?php

class RolesTableSeeder extends BasicSeeder
{
    public function run()
    {
        $this->importBasic('roles.csv', \App\Models\Role::class);
    }
}