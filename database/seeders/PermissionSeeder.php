<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = new Permission();
        $table->name='Opening.View';
        $table->save();
        $table = new Permission();
        $table->name='Opening.Add';
        $table->save();
        $table = new Permission();
        $table->name='Opening.Edit';
        $table->save();
        $table = new Permission();
        $table->name='Opening.Delete';
        $table->save();
        $table = new Permission();
        $table->name='User.View';
        $table->save();
        $table = new Permission();
        $table->name='User.Add';
        $table->save();
        $table = new Permission();
        $table->name='User.Edit';
        $table->save();
        $table = new Permission();
        $table->name='User.Delete';
        $table->save();
        $table = new Permission();
        $table->name='Role.View';
        $table->save();
        $table = new Permission();
        $table->name='Role.Add';
        $table->save();
        $table = new Permission();
        $table->name='Role.Edit';
        $table->save();
        $table = new Permission();
        $table->name='Role.Delete';
        $table->save();
        $table = new Permission();
        $table->name='Permission.View';
        $table->save();
        $table = new Permission();
        $table->name='Permission.Add';
        $table->save();
        $table = new Permission();
        $table->name='Permission.Edit';
        $table->save();
        $table = new Permission();
        $table->name='Permission.Delete';
        $table->save();
        $table = new Permission();
        $table->name='Application.View';
        $table->save();
        $table = new Permission();
        $table->name='Application.Add';
        $table->save();
        $table = new Permission();
        $table->name='Application.Edit';
        $table->save();
        $table = new Permission();
        $table->name='Application.Delete';
        $table->save();
        $table = new Permission();
        $table->name='Interview.View';
        $table->save();
        $table = new Permission();
        $table->name='Interview.Add';
        $table->save();
        $table = new Permission();
        $table->name='Interview.Edit';
        $table->save();
        $table = new Permission();
        $table->name='Interview.Delete';
        $table->save();
        $table = new Permission();
        $table->name='Department.View';
        $table->save();
        $table = new Permission();
        $table->name='Department.Add';
        $table->save();
        $table = new Permission();
        $table->name='Department.Edit';
        $table->save();
        $table = new Permission();
        $table->name='Department.Delete';
        $table->save();
        $table = new Permission();
        $table->name='review.view';
        $table->save();
        $table = new Permission();
        $table->name='review.add';
        $table->save();
        $table = new Permission();
        $table->name='candidate.select';
        $table->save();
        $table = new Permission();
        $table->name='candidate.reject';
        $table->save();
    }
}
