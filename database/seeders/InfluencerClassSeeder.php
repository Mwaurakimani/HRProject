<?php

namespace Database\Seeders;

use App\Models\InfluencerClass;
use App\Models\Platform;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InfluencerClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public static function run($file)
    {
        $json_data = json_decode(file_get_contents($file));

        $db_table_data= InfluencerClass::all();

        if(count($json_data) && count($db_table_data) <= 0){
            collect($json_data)->each(function($item){
                $platform_name= $item->name;

                $platform = Platform::where('name',$platform_name)->first();
                $platform_id = $platform->id;

                foreach ($item as $key => $value){
                    if($key == 'classes'){
                        foreach ($value as $key => $class){
                            $db_class = new InfluencerClass();

                            $db_class->platform_id = $platform_id;
                            $db_class->name = $class->name;
                            $db_class->min_count = $class->min_count;
                            $db_class->max_count = $class->max_count;
                            $db_class->save();
                        }
                    }
                }
            });
        }

    }
}
