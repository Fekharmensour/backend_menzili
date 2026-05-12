<?php

namespace App\Filament\Widgets;

use App\Models\Listing;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class ListingsChartWidget extends ChartWidget
{
    public function getHeading(): ?string
    {
        return __('admin.dashboard_stats.new_listings_8w');
    }
    protected static ?int $sort = 3;


    protected function getData(): array
    {
        $data = [];
        $labels = [];

        for ($i = 7; $i >= 0; $i--) {
            $start = Carbon::today()->subWeeks($i)->startOfWeek();
            $end = $start->copy()->endOfWeek();
            $labels[] = $start->format('d M');
            $data[] = Listing::whereBetween('created_at', [$start, $end])->count();
        }

        return [
            'datasets' => [
                [
                    'label' => __('admin.dashboard_stats.listings'),
                    'data' => $data,
                    'backgroundColor' => 'rgba(0, 120, 253, 0.7)',
                    'borderRadius' => 6,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
