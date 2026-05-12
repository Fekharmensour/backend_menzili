<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class NewUsersChartWidget extends ChartWidget
{
    public function getHeading(): ?string
    {
        return __('admin.dashboard_stats.new_users_30d');
    }
    protected static ?int $sort = 2;


    protected function getData(): array
    {
        $data = [];
        $labels = [];

        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $labels[] = $date->format('d M');
            $data[] = User::whereDate('created_at', $date)->count();
        }

        return [
            'datasets' => [
                [
                    'label' => __('admin.dashboard_stats.users'),
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
