<?php

namespace App\Filament\Widgets;

use App\Models\Boost;
use App\Models\CoinPurchase;
use App\Models\Listing;
use App\Models\Report;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalRevenue = CoinPurchase::where('status', 'completed')
            ->join('package_coins', 'coin_purchases.package_coin_id', '=', 'package_coins.id')
            ->sum('package_coins.price');

        return [
            Stat::make(__('admin.dashboard_stats.total_users'), User::count())
                ->description(User::whereDate('created_at', today())->count() . ' ' . __('admin.dashboard_stats.new_today'))
                ->descriptionIcon('heroicon-m-user-plus')
                ->color('primary'),

            Stat::make(__('admin.dashboard_stats.active_listings'), Listing::where('is_active', true)->count())
                ->description(Listing::where('moderation_status', 'pending')->count() . ' ' . __('admin.dashboard_stats.pending_moderation'))
                ->descriptionIcon('heroicon-m-home')
                ->color('success'),

            Stat::make(__('admin.dashboard_stats.pending_purchases'), CoinPurchase::where('status', 'pending')->count())
                ->description(__('admin.dashboard_stats.awaiting_admin'))
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('warning'),

            Stat::make(__('admin.dashboard_stats.open_reports'), Report::where('status', 'pending')->count())
                ->description(__('admin.dashboard_stats.require_review'))
                ->descriptionIcon('heroicon-m-flag')
                ->color('danger'),

            Stat::make(__('admin.dashboard_stats.active_boosts'), Boost::where('status', 'active')->where('expires_at', '>', now())->count())
                ->description(__('admin.dashboard_stats.currently_running'))
                ->descriptionIcon('heroicon-m-rocket-launch')
                ->color('info'),

            Stat::make(__('admin.dashboard_stats.revenue'), number_format($totalRevenue, 2) . ' DZD')
                ->description(__('admin.dashboard_stats.total_revenue_desc'))
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),
        ];
    }
}
