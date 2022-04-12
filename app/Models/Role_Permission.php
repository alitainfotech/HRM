<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role_Permission extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = null;
    public $incrementing = false;
    public function permission_role_permission(){
        return $this->hasOne('App\Models\Permission', 'id' ,'permission_id');
    }
    public function role_role_permission(){
        return $this->hasOne('App\Models\Role', 'id' ,'role_id');
    }
}
