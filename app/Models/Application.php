<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;
    public function candidate(){
        return $this->hasOne('App\Models\User', 'id' ,'c_id');
    }
    public function opening(){
        return $this->hasOne('App\Models\Opening', 'id' ,'o_id');
    }
}
