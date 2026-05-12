<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\FinancialChartWidget;
use App\Filament\Widgets\FinancialStatsWidget;
use App\Filament\Widgets\TopHoldersWidget;
use App\Models\CoinPurchase;
use App\Models\Member;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;

class WalletOverviewPage extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-presentation-chart-line';
    protected static string | \UnitEnum | null $navigationGroup = null;
    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): ?string
    {
        return __('admin.tools');
    }
    public static function getNavigationLabel(): string
    {
        return __('admin.financial_overview');
    }

    public function getTitle(): string
    {
        return __('admin.financial_overview');
    }

    public function getHeaderWidgets(): array
    {
        return [
            FinancialStatsWidget::class,
        ];
    }

    public function getFooterWidgets(): array
    {
        return [
            FinancialChartWidget::class,
            TopHoldersWidget::class,
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                //
            ])
            ->query(fn () => CoinPurchase::query()->where('status', 'completed')->latest())
            ->columns([
                TextColumn::make('member.user.name')
                    ->label(__('admin.member'))
                    ->searchable(),
                TextColumn::make('packageCoin.coins')
                    ->label(__('admin.coins'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('packageCoin.price')
                    ->label(__('admin.price') . ' (DZD)')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('payment_method')
                    ->label(__('admin.payment_method'))
                    ->badge(),
                TextColumn::make('created_at')
                    ->label(__('admin.date'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->paginated([5, 10, 25]);
    }
}
