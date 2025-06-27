<?php

namespace Database\Seeders;

use App\Models\Slot;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Employee;
use App\Models\Classification;
use App\Models\VendingMachine;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
     public function run(): void
    {
        // Create Classifications
        $manager = Classification::create([
            'name' => 'Manager',
            'daily_juice_limit' => 3,
            'daily_meal_limit' => 2,
            'daily_snack_limit' => 2,
            'daily_point_limit' => 500,
        ]);

        $employee = Classification::create([
            'name' => 'Regular Employee',
            'daily_juice_limit' => 1,
            'daily_meal_limit' => 1,
            'daily_snack_limit' => 1,
            'daily_point_limit' => 300,
        ]);

        $supervisor = Classification::create([
            'name' => 'Supervisor',
            'daily_juice_limit' => 2,
            'daily_meal_limit' => 1,
            'daily_snack_limit' => 2,
            'daily_point_limit' => 400,
        ]);

        // Create Sample Employees
        Employee::create([
            'full_name' => 'John Manager',
            'card_number' => 'CARD001',
            'classification_id' => $manager->id,
            'status' => 'active',
        ]);

        Employee::create([
            'full_name' => 'Jane Employee',
            'card_number' => 'CARD002',
            'classification_id' => $employee->id,
            'status' => 'active',
        ]);

        Employee::create([
            'full_name' => 'Bob Supervisor',
            'card_number' => 'CARD003',
            'classification_id' => $supervisor->id,
            'status' => 'active',
        ]);

        // Create Vending Machines
        $machine1 = VendingMachine::create([
            'location' => 'Main Office - Floor 1',
            'status' => 'active',
        ]);

        $machine2 = VendingMachine::create([
            'location' => 'Cafeteria - Floor 2',
            'status' => 'active',
        ]);

        // Create Slots for Machine 1
        // Juices (1-10)
        for ($i = 1; $i <= 10; $i++) {
            Slot::create([
                'machine_id' => $machine1->id,
                'slot_number' => $i,
                'category' => 'juice',
                'price' => 50,
                'product_name' => "Juice Product $i",
            ]);
        }

        // Meals (11-30)
        for ($i = 11; $i <= 30; $i++) {
            Slot::create([
                'machine_id' => $machine1->id,
                'slot_number' => $i,
                'category' => 'meal',
                'price' => 150,
                'product_name' => "Meal Product " . ($i - 10),
            ]);
        }

        // Snacks (31-40)
        for ($i = 31; $i <= 40; $i++) {
            Slot::create([
                'machine_id' => $machine1->id,
                'slot_number' => $i,
                'category' => 'snack',
                'price' => 75,
                'product_name' => "Snack Product " . ($i - 30),
            ]);
        }

        // Create Slots for Machine 2 (similar structure)
        // Juices (1-10)
        for ($i = 1; $i <= 10; $i++) {
            Slot::create([
                'machine_id' => $machine2->id,
                'slot_number' => $i,
                'category' => 'juice',
                'price' => 50,
                'product_name' => "Juice Product $i",
            ]);
        }

        // Meals (11-30)
        for ($i = 11; $i <= 30; $i++) {
            Slot::create([
                'machine_id' => $machine2->id,
                'slot_number' => $i,
                'category' => 'meal',
                'price' => 150,
                'product_name' => "Meal Product " . ($i - 10),
            ]);
        }

        // Snacks (31-40)
        for ($i = 31; $i <= 40; $i++) {
            Slot::create([
                'machine_id' => $machine2->id,
                'slot_number' => $i,
                'category' => 'snack',
                'price' => 75,
                'product_name' => "Snack Product " . ($i - 30),
            ]);
        }
    }
}


