<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    use HasFactory;

    protected $fillable = [
    'machine_id' ,
    'slot_number' ,
    'category' , 
    'price' ,
    'product_name'
    ];

    public function machine()
    {
        return $this->belongsTo(VendingMachine::class , 'machine_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}

