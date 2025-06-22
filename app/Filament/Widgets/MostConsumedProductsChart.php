<?php
namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\LineChartWidget;
use Illuminate\Support\Carbon;

class MostConsumedProductsLineChart extends LineChartWidget
{
    protected static ?string $heading = 'Most Consumed Products (Last 7 Days)';

    protected function getData(): array
    {
        // تحديد الأيام الـ 7 الأخيرة
        $dates = collect();
        for ($i = 6; $i >= 0; $i--) {
            $dates->push(Carbon::today()->subDays($i)->toDateString());
        }

        // جلب المعاملات الناجحة خلال آخر 7 أيام
        $transactions = Transaction::with('slot')
            ->where('status', 'success')
            ->whereDate('transaction_time', '>=', Carbon::today()->subDays(6))
            ->get();

        // تجهيز البيانات: [اسم المنتج => [تاريخ => عدد]]
        $productData = [];

        foreach ($transactions as $transaction) {
            $product = $transaction->slot?->product_name ?? 'Unknown';
            $date = Carbon::parse($transaction->transaction_time)->toDateString();

            if (!isset($productData[$product])) {
                $productData[$product] = array_fill_keys($dates->toArray(), 0);
            }

            $productData[$product][$date]++;
        }

        // تجهيز الـ datasets للـ chart
        $datasets = [];
        foreach (array_slice($productData, 0, 5) as $product => $dailyCounts) {
            $datasets[] = [
                'label' => $product,
                'data' => array_values($dailyCounts),
            ];
        }

        return [
            'datasets' => $datasets,
            'labels' => $dates->toArray(),
        ];
    }
}
