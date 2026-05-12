<?php

namespace App\Filament\Widgets;

use App\Models\FcmToken;
use App\Models\Notification;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class NotificationStatsWidget extends BaseWidget
{
    protected static bool $isDiscovered = false;

    protected function getStats(): array
    {
        $totalSent       = Notification::count();
        $broadcastCount  = Notification::whereNull('user_id')->count();
        $personalCount   = Notification::whereNotNull('user_id')->count();
        $activeTokens    = FcmToken::distinct('token')->count('token');
        $readCount       = Notification::where('is_read', true)->count();
        $unreadCount     = Notification::where('is_read', false)->count();
        $sentLast7Days   = Notification::where('created_at', '>=', now()->subDays(7))->count();

        return [
            Stat::make(__('admin.total_notifications'), number_format($totalSent))
                ->description(__('admin.all_time'))
                ->icon('heroicon-o-paper-airplane')
                ->color('primary'),

            Stat::make(__('admin.broadcast_notifications'), number_format($broadcastCount))
                ->icon('heroicon-o-megaphone')
                ->color('warning'),

            Stat::make(__('admin.personal_notifications'), number_format($personalCount))
                ->icon('heroicon-o-user')
                ->color('info'),

            Stat::make(__('admin.active_devices'), number_format($activeTokens))
                ->icon('heroicon-o-device-phone-mobile')
                ->color('success'),

            Stat::make(__('admin.read_notifications'), number_format($readCount))
                ->icon('heroicon-o-check-circle')
                ->color('success'),

            Stat::make(__('admin.unread_notifications'), number_format($unreadCount))
                ->icon('heroicon-o-bell-alert')
                ->color('danger'),

            Stat::make(__('admin.notifications_last_7d'), number_format($sentLast7Days))
                ->icon('heroicon-o-calendar-days')
                ->color('primary')
                ->extraAttributes(['class' => 'col-span-2']),
        ];
    }
}
