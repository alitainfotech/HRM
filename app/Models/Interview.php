<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    use HasFactory;
    public function application(){
        return $this->hasOne('App\Models\Application', 'id' ,'a_id');

    }
    public function tl(){
        return $this->hasOne('App\Models\Admin', 'id' ,'tl_id');
    }
}
