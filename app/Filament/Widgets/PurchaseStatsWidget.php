<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\Employee;
use App\Models\Slot;
use App\Models\Transaction;
use App\Models\VendingMachine;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Illuminate\Support\Facades\DB;

class PurchaseStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $today = Carbon::today();

        $todayTransactions = Transaction::whereDate('transaction_time', $today);
        $successfulToday = $todayTransactions->where('status', 'success')->count();
        $failedToday = $todayTransactions->where('status', 'failure')->count();

        // ✅ استعلام للمنتج الأكثر مبيعًا (حسب slot_id ومن ثم جلب اسم المنتج من جدول slots)
        $topSelling = Transaction::select('slot_id', DB::raw('count(*) as total'))
            ->where('status', 'success')
            ->groupBy('slot_id')
            ->orderByDesc('total')
            ->first();

        $topProductName = 'N/A';
        $topProductCount = 0;

        if ($topSelling) {
            $slot = Slot::find($topSelling->slot_id);
            if ($slot && $slot->product_name) {
                $topProductName = $slot->product_name;
                $topProductCount = $topSelling->total;
            }
        }

        return [
            Stat::make('Total Employees', Employee::where('status', 'active')->count())
                ->description('Active employees')
                ->descriptionIcon('heroicon-o-users')
                ->color('success'),

            Stat::make('Successful Purchases Today', $successfulToday)
                ->description('Completed transactions')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success'),

            Stat::make('Failed Purchases Today', $failedToday)
                ->description('Rejected transactions')
                ->descriptionIcon('heroicon-o-x-circle')
                ->color('danger'),

            Stat::make('Active Vending Machines', VendingMachine::where('status', 'active')->count())
                ->description('Operational machines')
                ->descriptionIcon('heroicon-o-building-storefront')
                ->color('primary'),

            Stat::make('Top Product: ' . $topProductName, $topProductCount)
                ->description('Most sold product')
                ->descriptionIcon('heroicon-o-fire')
                ->color('warning'),
        ];
    }
}
