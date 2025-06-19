<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Classification extends Model
{
    use HasFactory;

      protected $fillable = [
        'name',
        'daily_juice_limit',
        'daily_meal_limit',
        'daily_snack_limit',
        'daily_point_limit',
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}


