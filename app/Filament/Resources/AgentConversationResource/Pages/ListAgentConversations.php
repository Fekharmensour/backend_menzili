<?php

namespace App\Filament\Resources\AgentConversationResource\Pages;

use App\Filament\Resources\AgentConversationResource;
use App\Filament\Widgets\AgentConversationStatsWidget;
use Filament\Resources\Pages\ListRecords;

class ListAgentConversations extends ListRecords
{
    protected static string $resource = AgentConversationResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            AgentConversationStatsWidget::class,
        ];
    }
}
