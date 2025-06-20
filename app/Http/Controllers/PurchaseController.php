<?php

namespace App\Http\Controllers;

use App\Http\Requests\purchaseRequest;
use App\Models\Employee;
use App\Models\Slot;
use App\Models\VendingMachine;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function purchase(purchaseRequest $request) : JsonResponse 
    {

        $data = $request->validated();

        try {

        $employee = Employee::where('card_number' , $data['card_number'])
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
        $machine = VendingMachine::where('id', $data['machine_id'])
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

        }catch(Exception $e) {

        }
    }
}
