<?php

namespace App\Filament\Widgets;

use App\Models\AgentConversation;
use App\Models\AgentConversationMessage;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AgentConversationStatsWidget extends BaseWidget
{
    protected static ?int $sort = 1;
    protected static bool $isDiscovered = false;

    protected function getStats(): array
    {
        $totalConversations = AgentConversation::count();
        $totalMessages      = AgentConversationMessage::count();
        $uniqueUsers        = AgentConversation::distinct('user_id')->count('user_id');
        $avgMessagesPerConv = $totalConversations > 0
            ? round($totalMessages / $totalConversations, 1)
            : 0;

        // Last 30 days
        $recentConversations = AgentConversation::where('created_at', '>=', now()->subDays(30))->count();
        $recentMessages      = AgentConversationMessage::where('created_at', '>=', now()->subDays(30))->count();

        return [
            Stat::make(__('admin.total_conversations'), $totalConversations)
                ->description(__('admin.all_time'))
                ->icon('heroicon-o-chat-bubble-left-right')
                ->color('primary'),

            Stat::make(__('admin.total_messages_sent'), $totalMessages)
                ->description(__('admin.all_time'))
                ->icon('heroicon-o-paper-airplane')
                ->color('info'),

            Stat::make(__('admin.unique_users_chatbot'), $uniqueUsers)
                ->description(__('admin.members_used_ai'))
                ->icon('heroicon-o-users')
                ->color('success'),

            Stat::make(__('admin.avg_messages_per_conv'), $avgMessagesPerConv)
                ->description(__('admin.messages_per_session'))
                ->icon('heroicon-o-chart-bar')
                ->color('warning'),

            Stat::make(__('admin.conversations_last_30d'), $recentConversations)
                ->description(__('admin.new_conversations_month'))
                ->icon('heroicon-o-calendar')
                ->color('primary'),

            Stat::make(__('admin.messages_last_30d'), $recentMessages)
                ->description(__('admin.messages_sent_month'))
                ->icon('heroicon-o-chat-bubble-oval-left')
                ->color('info'),
        ];
    }
}
