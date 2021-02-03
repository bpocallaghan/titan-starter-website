<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(NavigationsTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(PagesTableSeeder::class);
        $this->call(SectionsTableSeeder::class);
        $this->call(TemplatesTableSeeder::class);
    }
}
