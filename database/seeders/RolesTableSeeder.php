<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends BasicSeeder
{
    public function run()
    {
        $this->importBasic('roles.csv', \App\Models\Role::class);
    }
}
