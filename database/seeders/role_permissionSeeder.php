<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role_Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class role_permissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role__permissions')->where('role_id',1)->delete();
        $permissions= Permission::where('status',1)->get();
        foreach($permissions as $permission){
            $table = new Role_Permission();
            $table->role_id='1';
            $table->permission_id=$permission->id;
            $table->save();
        }
    }
}