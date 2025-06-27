<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
   use HasFactory;

    protected $fillable = [
        'full_name',
        'card_number',
        'classification_id',
        'status',
        'current_balance',
        'last_recharge_date',
    ];

    protected $casts = [
        'last_recharge_date' => 'date',
    ];

    public function classification()
    {
        return $this->belongsTo(Classification::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function dailyConsumption()
    {
        return $this->hasMany(DailyConsumption::class);
    }

    public function getTodayConsumption()
    {
       return $this->dailyConsumption()
            ->where('consumption_date', Carbon::today())
            ->first() ?? new DailyConsumption([
                'juice_count' => 0,
                'meal_count' => 0,
                'snack_count' => 0,
                'points_used' => 0,
            ]);
    }

       public function rechargeBalance()
    {
        $today = Carbon::today();
        
        if ($this->last_recharge_date != $today) {
            $this->current_balance = $this->classification->daily_point_limit;
            $this->last_recharge_date = $today;
            $this->save();
            
            // Reset daily consumption
            $this->dailyConsumption()->updateOrCreate(
                ['consumption_date' => $today],
                [
                    'juice_count' => 0,
                    'meal_count' => 0,
                    'snack_count' => 0,
                    'points_used' => 0,
                ]
            );
        }
    }

    public function canPurchase($category, $price)
    {
        $this->rechargeBalance();
        $todayConsumption = $this->getTodayConsumption();
        $classification = $this->classification;

        // Check balance
        if ($this->current_balance < $price) {
            return ['can_purchase' => false, 'reason' => 'Insufficient balance'];
        }

        // Check category limits
        switch ($category) {
            case 'juice':
                if ($todayConsumption->juice_count >= $classification->daily_juice_limit) {
                    return ['can_purchase' => false, 'reason' => 'Daily juice limit exceeded'];
                }
                break;
            case 'meal':
                if ($todayConsumption->meal_count >= $classification->daily_meal_limit) {
                    return ['can_purchase' => false, 'reason' => 'Daily meal limit exceeded'];
                }
                break;
            case 'snack':
                if ($todayConsumption->snack_count >= $classification->daily_snack_limit) {
                    return ['can_purchase' => false, 'reason' => 'Daily snack limit exceeded'];
                }
                break;
        }

        return ['can_purchase' => true];

    }

    public function processPurchase($slot, $price)
    {
        $canPurchase = $this->canPurchase($slot->category, $price);
        
        if (!$canPurchase['can_purchase']) {
            return $canPurchase;
        }

        // Deduct balance
        $this->current_balance -= $price;
        $this->save();

        // Update consumption
        $today = Carbon::today();
        $consumption = $this->dailyConsumption()->firstOrCreate(
            ['consumption_date' => $today],
            [
                'juice_count' => 0,
                'meal_count' => 0,
                'snack_count' => 0,
                'points_used' => 0,
            ]
        );

        $consumption->points_used += $price;
        switch ($slot->category) {
            case 'juice':
                $consumption->juice_count++;
                break;
            case 'meal':
                $consumption->meal_count++;
                break;
            case 'snack':
                $consumption->snack_count++;
                break;
        }
        $consumption->save();

        return ['can_purchase' => true, 'message' => 'Purchase successful'];
    }

    
}
