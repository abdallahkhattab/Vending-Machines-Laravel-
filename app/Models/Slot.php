<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    protected $fillable = [
    'machine_id' ,
    'slot_number' ,
    'category' , 
    'price' ,
    'product_name'
    ];
}
