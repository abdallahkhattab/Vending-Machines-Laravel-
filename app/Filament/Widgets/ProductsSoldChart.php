<?php
namespace App\Filament\Widgets;

use App\Models\Slot;
use App\Models\Transaction;
use Filament\Widgets\BarChartWidget;

class ProductsSoldChart extends BarChartWidget
{
    protected static ?string $heading = 'Products Sold Count';

    protected function getData(): array
    {
        // استعلام يجمع عدد المبيعات الناجحة لكل منتج
        $data = Transaction::where('status', 'success')
            ->select('slot_id', \DB::raw('COUNT(*) as total'))
            ->groupBy('slot_id')
            ->with('slot') // مهم إذا عندك علاقة slot في الموديل
            ->get()
            ->map(function ($item) {
                return [
                    'product' => optional($item->slot)->product_name ?? 'Unknown',
                    'total' => $item->total,
                ];
            });

        return [
            'datasets' => [
                [
                    'label' => 'Sold Count',
                    'data' => $data->pluck('total')->toArray(),
                ],
            ],
            'labels' => $data->pluck('product')->toArray(),
        ];
    }
}
