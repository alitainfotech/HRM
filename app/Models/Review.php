<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    public function getInterview(){
        return $this->belongsTo('App\Models\Interview', 'i_id' ,'id');
    }
}