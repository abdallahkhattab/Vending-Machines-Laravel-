<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
   use HasFactory;

    protected $fillable = [
    'employee_id',
    'machine_id',
    'slot_id',
    'points_deducted',
    'status',
    'failure_reason',
    'transaction_time',
];

protected $casts = [
    'transaction_time' => 'datetime',
];

public function employee()
{
    return $this->belongsTo(Employee::class);
}

public function machine()
{
    return $this->belongsTo(VendingMachine::class , 'machine_id');
}

   public function slot()
    {
        return $this->belongsTo(Slot::class);
    }


}
