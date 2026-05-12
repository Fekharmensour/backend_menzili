<?php

namespace App\Filament\Widgets;

use App\Models\CoinPurchase;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class FinancialChartWidget extends ChartWidget
{
    protected ?string $heading = 'Revenue Trend (30 Days)';

    public static function canView(): bool
    {
        return request()->routeIs('*.wallet-overview-page');
    }

    public function getHeading(): ?string
    {
        return __('admin.revenue') . ' (' . __('admin.dashboard_stats.recent_activity') . ')';
    }

    protected function getData(): array
    {
        $data = [];
        $labels = [];

        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $labels[] = $date->format('d M');
            
            $revenue = CoinPurchase::where('status', 'completed')
                ->whereDate('coin_purchases.created_at', $date)
                ->join('package_coins', 'coin_purchases.package_coin_id', '=', 'package_coins.id')
                ->sum('package_coins.price');
                
            $data[] = (int) $revenue;
        }

        return [
            'datasets' => [
                [
                    'label' => __('admin.revenue') . ' (DZD)',
                    'data' => $data,
                    'borderColor' => '#0078fd',
                    'backgroundColor' => 'rgba(0, 120, 253, 0.1)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
