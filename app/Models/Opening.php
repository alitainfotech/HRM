<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opening extends Model
{
    use HasFactory;
    protected $table = "openings";
    protected $primaryKey = "id";
    public function setTitleAttribute($value){
        $this->attributes['title'] = ucwords($value);
    }
    public function setDescriptionAttribute($value){
        $this->attributes['description'] = ucwords($value);
    }
    public function application(){
        return $this->hasMany('App\Models\Application', 'o_id' ,'id');
    }
}
