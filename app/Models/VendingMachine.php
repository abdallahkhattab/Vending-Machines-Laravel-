<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendingMachine extends Model
{
use HasFactory;

protected $fillable = 
[
    'location' ,
     'status'
];

    public function slots()
    {
        return $this->hasMany(Slot::class , 'machine_id');
    }

      public function transactions()
    {
        return $this->hasMany(Transaction::class, 'machine_id');
    }
}
