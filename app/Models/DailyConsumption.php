<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DailyConsumption extends Model
{
      use HasFactory;

    protected $fillable = [
        'employee_id',
        'consumption_date',
        'juice_count',
        'meal_count',
        'snack_count',
        'points_used',
    ];

    protected $casts = [
        'consumption_date' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
