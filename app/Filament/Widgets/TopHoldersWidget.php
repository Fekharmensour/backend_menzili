<?php

namespace App\Filament\Widgets;

use App\Models\Member;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class TopHoldersWidget extends BaseWidget
{
    protected static ?int $sort = 3;

    public static function canView(): bool
    {
        return request()->routeIs('*.wallet-overview-page');
    }

    public function getHeading(): ?string
    {
        return __('admin.dashboard_stats.top_holders');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Member::with('user')
                    ->join('wallets', function ($join) {
                        $join->on('members.id', '=', 'wallets.holder_id')
                            ->where('wallets.holder_type', '=', Member::class);
                    })
                    ->select('members.*', 'wallets.balance as wallet_balance')
                    ->orderByDesc('wallets.balance')
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('admin.member')),
                Tables\Columns\TextColumn::make('wallet_balance')
                    ->label(__('admin.wallet_balance'))
                    ->formatStateUsing(fn ($state) => number_format($state) . ' ' . __('admin.dashboard_stats.tokens'))
                    ->badge()
                    ->color('primary'),
            ])
            ->paginated(false);
    }
}
