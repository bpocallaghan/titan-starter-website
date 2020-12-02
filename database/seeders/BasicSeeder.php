<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BasicSeeder extends Seeder
{
    /**
     * Prepare CSV Rows to insert the array into the database
     * @param $keys
     * @param $item
     * @return array
     */
    private function prepareCSVRowsToInsertIntoDB($keys, $item)
    {
        $data = [];
        foreach ($keys as $k => $column) {

            // convert to null
            if (in_array($column, [
                'deleted_at',
                'created_by',
                'updated_by',
                'deleted_by',
                'discount_percent',
                'expired_at',
                'max_uses_per_user',
                'zoom_level',
                'city_id',
                'province_id',
                'country_id',
                'continent_id',
                'list_order',
                'list_main_order',
                'list_footer_order',
                'list_client_order',
                'list_business_order',
                'featured_order',
                'max_locations',
            ])) {
                $data[$column] = $item[$column] !== '' ? $item[$column] : null;
            } else {
                $data[$column] = $item[$column];
            }
        }

        return $data;
    }

    public function importBasic($filename, $eloquent, $truncate = true)
    {
        // if truncate table
        if ($truncate) {
            app($eloquent)::truncate();
        }

        // load file
        $csvPath = database_path() . DIRECTORY_SEPARATOR . 'seeders' . DIRECTORY_SEPARATOR . 'csv' . DIRECTORY_SEPARATOR . $filename;
        $items = csv_to_array($csvPath);

        // all keys in file
        $keys = array_keys($items[0]);
        foreach ($items as $key => $item) {

            $data = $this->prepareCSVRowsToInsertIntoDB($keys, $item);

            // create
            app($eloquent)::create($data);
        }
    }

    public function importBasicTable($filename, $table, $truncate = true)
    {
        // if truncate table
        if ($truncate) {
            \DB::table($table)->truncate();
        }

        // load file
        $csvPath = database_path() . DIRECTORY_SEPARATOR . 'seeders' . DIRECTORY_SEPARATOR . 'csv' . DIRECTORY_SEPARATOR . $filename;
        $items = csv_to_array($csvPath);

        // all keys in file
        $keys = array_keys($items[0]);
        foreach ($items as $key => $item) {

            $data = $this->prepareCSVRowsToInsertIntoDB($keys, $item);

            // insert
            \DB::table($table)->insert([
                $data
            ]);
        }
    }
}
