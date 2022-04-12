<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    protected $table = "permissions";
    protected $primaryKey = "id";
    public function setNameAttribute($value){
        $this->attributes['name'] = ucwords($value);
    }
    public function permission_role_permission(){
        return $this->hasMany('App\Models\Role_Permission', 'role_id' ,'id');
    }
}
