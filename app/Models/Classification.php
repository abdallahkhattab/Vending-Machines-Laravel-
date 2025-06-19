<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classification extends Model
{
    protected $fillable = [
        'name' , 'daily_juice_limit' , 'daily_meal_limit' ,
        'daily_snack_limit' , 'daily_point_limit'
    ];
}


