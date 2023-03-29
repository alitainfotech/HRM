<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->full_name = "rajvi vora";
        $user->user_name = "AI1001";
        $user->email = "rajvi@alitainfotech.com";
        $user->password = Hash::make('Rajvi_12');
        $user->save();
    }
}