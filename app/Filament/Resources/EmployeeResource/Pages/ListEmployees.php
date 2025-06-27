<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use App\Models\Employee;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListEmployees extends ListRecords
{
    protected static string $resource = EmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('recharge_all')
                ->label('Recharge All Active Employees')
                ->icon('heroicon-o-battery-100')
                ->action(function () {
                    $employees = Employee::where('status', 'active')->get();

                    foreach ($employees as $employee) {
                        $employee->rechargeBalance();
                    }

                    Notification::make()
                        ->title('All active employees have been recharged!')
                        ->success()
                        ->send();
                })
                ->requiresConfirmation()
                ->color('success'),
        ];
    }
}
