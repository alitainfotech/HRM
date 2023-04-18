<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $permissions = [
            ['name' => 'Opening.View', 'status' => 1] ,
            ['name' => 'Opening.Add', 'status' => 1] ,
            ['name' => 'Opening.Edit', 'status' => 1] ,
            ['name' => 'Opening.Delete', 'status' => 1] ,
            ['name' => 'User.View', 'status' => 1] ,
            ['name' => 'User.Add', 'status' => 1] ,
            ['name' => 'User.Edit', 'status' => 1] ,
            ['name' => 'User.Delete', 'status' => 1] ,
            ['name' => 'Role.View', 'status' => 1] ,
            ['name' => 'Role.Add', 'status' => 1] ,
            ['name' => 'Role.Edit', 'status' => 1] ,
            ['name' => 'Role.Delete', 'status' => 1] ,
            ['name' => 'Permission.View', 'status' => 1] ,
            ['name' => 'Permission.Add', 'status' => 1] ,
            ['name' => 'Permission.Edit', 'status' => 1] ,
            ['name' => 'Permission.Delete', 'status' => 1] ,
            ['name' => 'Application.View', 'status' => 1] ,
            ['name' => 'Application.Add', 'status' => 1] ,
            ['name' => 'Application.Edit', 'status' => 1] ,
            ['name' => 'Application.Delete', 'status' => 1] ,
            ['name' => 'Interview.View', 'status' => 1] ,
            ['name' => 'Interview.Add', 'status' => 1] ,
            ['name' => 'Interview.Edit', 'status' => 1] ,
            ['name' => 'Interview.Delete', 'status' => 1] ,
            ['name' => 'Department.View', 'status' => 1] ,
            ['name' => 'Department.Add', 'status' => 1] ,
            ['name' => 'Department.Edit', 'status' => 1] ,
            ['name' => 'Department.Delete', 'status' => 1] ,
            ['name' => 'review.view', 'status' => 1] ,
            ['name' => 'review.ad', 'status' => 1] ,
            ['name' => 'candidate.select', 'status' => 1] ,
            ['name' => 'candidate.reject', 'status' => 1] ,
            ['name' => 'review-list.index', 'status' => 1] ,
            ['name' => 'Applicant.View', 'status' => 1] ,
        ];

        Permission::insert($permissions);

        // $table = new Permission();
        // $table->name='Opening.View';
        // $table->save();
        // $table = new Permission();
        // $table->name='Opening.Add';
        // $table->save();
        // $table = new Permission();
        // $table->name='Opening.Edit';
        // $table->save();
        // $table = new Permission();
        // $table->name='Opening.Delete';
        // $table->save();
        // $table = new Permission();
        // $table->name='User.View';
        // $table->save();
        // $table = new Permission();
        // $table->name='User.Add';
        // $table->save();
        // $table = new Permission();
        // $table->name='User.Edit';
        // $table->save();
        // $table = new Permission();
        // $table->name='User.Delete';
        // $table->save();
        // $table = new Permission();
        // $table->name='Role.View';
        // $table->save();
        // $table = new Permission();
        // $table->name='Role.Add';
        // $table->save();
        // $table = new Permission();
        // $table->name='Role.Edit';
        // $table->save();
        // $table = new Permission();
        // $table->name='Role.Delete';
        // $table->save();
        // $table = new Permission();
        // $table->name='Permission.View';
        // $table->save();
        // $table = new Permission();
        // $table->name='Permission.Add';
        // $table->save();
        // $table = new Permission();
        // $table->name='Permission.Edit';
        // $table->save();
        // $table = new Permission();
        // $table->name='Permission.Delete';
        // $table->save();
        // $table = new Permission();
        // $table->name='Application.View';
        // $table->save();
        // $table = new Permission();
        // $table->name='Application.Add';
        // $table->save();
        // $table = new Permission();
        // $table->name='Application.Edit';
        // $table->save();
        // $table = new Permission();
        // $table->name='Application.Delete';
        // $table->save();
        // $table = new Permission();
        // $table->name='Interview.View';
        // $table->save();
        // $table = new Permission();
        // $table->name='Interview.Add';
        // $table->save();
        // $table = new Permission();
        // $table->name='Interview.Edit';
        // $table->save();
        // $table = new Permission();
        // $table->name='Interview.Delete';
        // $table->save();
        // $table = new Permission();
        // $table->name='Department.View';
        // $table->save();
        // $table = new Permission();
        // $table->name='Department.Add';
        // $table->save();
        // $table = new Permission();
        // $table->name='Department.Edit';
        // $table->save();
        // $table = new Permission();
        // $table->name='Department.Delete';
        // $table->save();
        // $table = new Permission();
        // $table->name='review.view';
        // $table->save();
        // $table = new Permission();
        // $table->name='review.add';
        // $table->save();
        // $table = new Permission();
        // $table->name='candidate.select';
        // $table->save();
        // $table = new Permission();
        // $table->name='candidate.reject';
        // $table->save();
        // $table = new Permission();
        // $table->name='review-list.index';
        // $table->save();
        // $table = new Permission();
        // $table->name='Applicant.View';
        // $table->save();
    }
}