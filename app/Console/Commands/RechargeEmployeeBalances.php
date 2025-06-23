<?php

namespace App\Console\Commands;

use App\Models\Employee;
use Illuminate\Console\Command;

class RechargeEmployeeBalances extends Command
{
    protected $signature = 'employees:recharge';
    protected $description = 'Recharge all active employee balances';

    public function handle()
    {
        $employees = Employee::where('status', 'active')->get();
        $count = 0;
        
        foreach ($employees as $employee) {
            $employee->rechargeBalance();
            $count++;
        }
        
        $this->info("Recharged $count employee balances successfully.");
        return Command::SUCCESS;
    }
}
