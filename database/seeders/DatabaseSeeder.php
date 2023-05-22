<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createAdmin();
    }

    function createAdmin(){
        $user = new User();

        $user->username = 'Admin';
        $user->first_name = 'Administrator';
        $user->last_name = 'Administrator';
        $user->email = 'admin@email.com';
        $user->phone = '0000000000';
        $user->identification_number = '0000000000';
        $user->password = bcrypt('password');
        $user->designation = 'Administrator';

        $user->save();
    }
}
