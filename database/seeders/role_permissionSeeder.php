<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role_Permission;
use Illuminate\Database\Seeder;

class role_permissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions= Permission::where('status',1)->get();
        foreach($permissions as $permission){
            $table = new Role_Permission();
            $table->role_id='1';
            $table->permission_id=$permission->id;
            $table->save();
        }
    }
}
