<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Slot;
use App\Models\Employee;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\VendingMachine;
use Illuminate\Support\Carbon;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\purchaseRequest;

class PurchaseController extends Controller
{
    public function purchase(purchaseRequest $request) : JsonResponse 
    {

        $data = $request->validated();

        try {

        $employee = Employee::where('card_number' , $request->card_number)
                    ->where('status' , 'active')
                    ->first();

            if (!$employee) {
                $this->logTransaction(null, $request, 'failure', 'Invalid card number');
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid card number or inactive employee'
                ], 400);
            }

          // Find vending machine
        $machine = VendingMachine::where('id', $request->machine_id)
                ->where('status', 'active')
                ->first();

            if (!$machine) {
                $this->logTransaction($employee->id, $request, 'failure', 'Invalid machine ID');
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid or inactive vending machine'
                ], 400);
            }
    
          // Find slot
            $slot = Slot::where('machine_id', $request->machine_id)
                ->where('slot_number', $request->slot_number)
                ->first();

             if (!$slot) {
                $this->logTransaction($employee->id, $request, 'failure', 'Invalid slot number');
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid slot number'
                ], 400);
            }  
            
            
            // Validate price
            if ($request->product_price != $slot->price) {
                $this->logTransaction($employee->id, $request, 'failure', 'Price mismatch');
                return response()->json([
                    'success' => false,
                    'message' => 'Product price mismatch'
                ], 400);
            }

            // Process purchase
            $result = $employee->processPurchase($slot, $request->product_price);

                if ($result['can_purchase']) {
                $this->logTransaction(
                    $employee->id,
                    $request,
                    'success',
                    null,
                    $slot->id,
                    $request->product_price
                );

                return response()->json([
                    'success' => true,
                    'message' => 'Purchase successful',
                    'remaining_balance' => $employee->current_balance,
                    'product_dispensed' => $slot->product_name ?? "Slot {$slot->slot_number}"
                ]);
                } else {
                $this->logTransaction($employee->id, $request, 'failure', $result['reason'], $slot->id);
                return response()->json([
                    'success' => false,
                    'message' => $result['reason']
                ], 400);
            }

        }catch(Exception $e) {

                $this->logTransaction(
                $employee->id ?? null,
                $request,
                'failure',
                'System error: ' . $e->getMessage()
            );

            return response()->json([
                'success' => false,
                'message' => 'System error occurred'
            ], 500);

        }
    }

    public function getEmployeeBalance(Request $request) : JsonResponse
    {

          $request->validate([
            'card_number' => 'required|string',
        ]);

        $employee = Employee::where('card_number' , $request->card_number)
                    ->where('status' , 'active')
                    ->with('classification')
                    ->first();

         if (!$employee) {
            return response()->json([
                'success' => false,
                'message' => 'Employee not found'
            ], 404);
        }

        $employee->rechargeBalance();
        $todayConsumption = $employee->getTodayConsumption();

           return response()->json([
            'success' => true,
            'data' => [
                'employee_name' => $employee->full_name,
                'current_balance' => $employee->current_balance,
                'classification' => $employee->classification->name,
                'today_consumption' => [
                    'juice_count' => $todayConsumption->juice_count,
                    'meal_count' => $todayConsumption->meal_count,
                    'snack_count' => $todayConsumption->snack_count,
                    'points_used' => $todayConsumption->points_used,
                ],
                'limits' => [
                    'daily_juice_limit' => $employee->classification->daily_juice_limit,
                    'daily_meal_limit' => $employee->classification->daily_meal_limit,
                    'daily_snack_limit' => $employee->classification->daily_snack_limit,
                    'daily_point_limit' => $employee->classification->daily_point_limit,
                ]
            ]
        ]);
    }

     private function logTransaction($employeeId, $request, $status, $failureReason = null, $slotId = null, $pointsDeducted = 0)
    {
        Transaction::create([
            'employee_id' => $employeeId,
            'machine_id' => $request->machine_id,
            'slot_id' => $slotId,
            'points_deducted' => $pointsDeducted,
            'status' => $status,
            'failure_reason' => $failureReason,
            'transaction_time' => Carbon::now(),
        ]);
    }
}
