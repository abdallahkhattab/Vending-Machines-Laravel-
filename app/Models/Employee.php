<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
   protected $fillable = [
    'full_name',
    'card_number',
    'classification_id',
    'status',
    'current_balance',
    'last_recharge_date',
];

}
