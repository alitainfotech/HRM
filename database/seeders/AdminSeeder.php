<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new Admin();
        $user->full_name = "henish patel";
        $user->email = "admin@gmail.com";
        $user->password = Hash::make('Admin_12');
        $user->designation = "CEO";
        $user->role_id = "1";
        $user->save();
    }
}

