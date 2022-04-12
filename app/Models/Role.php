<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    public function role_role_permission(){
        return $this->hasMany('App\Models\Role_Permission', 'role_id' ,'id');
    }
}
