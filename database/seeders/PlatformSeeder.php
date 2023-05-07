<?php

namespace Database\Seeders;

use App\Models\Platform;
use Illuminate\Database\Seeder;

class PlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public static function run($file)
    {
        $json_data = json_decode(file_get_contents($file));

        $model = new Platform();
        $db_table_data = $model::all();

        if (count($json_data) && count($db_table_data) <= 0) {
            collect($json_data)->each(function ($item) {
                $model = new Platform;

                $model->name = $item->name;
                $model->link = $item->link;
                $model->save();
            });
        }
    }
}
