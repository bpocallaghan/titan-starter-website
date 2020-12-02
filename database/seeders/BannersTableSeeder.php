<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Banner;

class BannersTableSeeder extends Seeder
{
	public function run(Faker\Generator $faker)
	{
		$csvPath = database_path() . DIRECTORY_SEPARATOR . 'seeds' . DIRECTORY_SEPARATOR . 'csv' . DIRECTORY_SEPARATOR . 'banners.csv';
        $items = csv_to_array($csvPath);

        foreach ($items as $key => $item)
        {
            Banner::create([

            ]);
        }
	}
}
