<?php

namespace App\Filament\Widgets;

use App\Models\CoinPurchase;
use App\Models\Member;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class FinancialStatsWidget extends BaseWidget
{
    public static function canView(): bool
    {
        return request()->routeIs('*.wallet-overview-page');
    }

    protected function getStats(): array
    {
        $totalTokens = (int) DB::table('wallets')->where('holder_type', Member::class)->sum('balance');
        $totalRevenue = (int) CoinPurchase::where('status', 'completed')
            ->join('package_coins', 'coin_purchases.package_coin_id', '=', 'package_coins.id')
            ->sum('package_coins.price');
        $pendingRevenue = (int) CoinPurchase::where('status', 'pending')
            ->join('package_coins', 'coin_purchases.package_coin_id', '=', 'package_coins.id')
            ->sum('package_coins.price');

        return [
            Stat::make(__('admin.dashboard_stats.total_tokens'), number_format($totalTokens))
                ->description(__('admin.dashboard_stats.tokens'))
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('primary'),

            Stat::make(__('admin.dashboard_stats.revenue'), number_format($totalRevenue) . ' DZD')
                ->description(__('admin.dashboard_stats.total_revenue_desc'))
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('success'),

            Stat::make(__('admin.dashboard_stats.pending_purchases'), number_format($pendingRevenue) . ' DZD')
                ->description(__('admin.dashboard_stats.awaiting_admin'))
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
        ];
    }
}
