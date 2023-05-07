<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Platform;
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
        PlatformSeeder::run('./database/Data/platforms.json');
        InfluencerClassSeeder::run('./database/Data/InfluencerClasses.json');
    }
}
