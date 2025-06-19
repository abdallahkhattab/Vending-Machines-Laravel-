<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
    'employee_id',
    'machine_id',
    'slot_id',
    'points_deducted',
    'status',
    'failure_reason',
    'transaction_time',
];

}
