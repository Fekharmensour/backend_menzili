<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportResource\Pages;
use App\Models\Listing;
use App\Models\Member;
use App\Models\Report;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Actions;
use Filament\Tables\Table;
use App\Filament\Resources\ListingResource;
use App\Filament\Resources\MemberResource;
use Filament\Actions\ActionGroup;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-flag';
    protected static string | \UnitEnum | null $navigationGroup = null;
    protected static ?int $navigationSort = 1;

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->with(['reference', 'member.user']);
    }

    public static function getNavigationGroup(): ?string
    {
        return __('admin.moderation');
    }

    public static function getNavigationLabel(): string
    {
        return __('admin.reports');
    }

    public static function getModelLabel(): string
    {
        return __('admin.report');
    }

    public static function getPluralModelLabel(): string
    {
        return __('admin.reports');
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            \Filament\Schemas\Components\Section::make(__('admin.report_info'))->schema([
                \Filament\Infolists\Components\TextEntry::make('member.user.name')->label(__('admin.reporter')),
                \Filament\Infolists\Components\TextEntry::make('reference_type')
                    ->label(__('admin.type'))
                    ->formatStateUsing(fn ($state) => match ($state) {
                        Listing::class => __('admin.listing'),
                        Member::class  => __('admin.member'),
                        default        => class_basename($state),
                    }),
                \Filament\Infolists\Components\TextEntry::make('status')
                    ->label(__('admin.status'))
                    ->badge()
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'accepted',
                        'danger'  => 'rejected',
                    ]),
                \Filament\Infolists\Components\TextEntry::make('created_at')->label(__('admin.created_at'))->dateTime(),
                \Filament\Infolists\Components\TextEntry::make('report')
                    ->label(__('admin.reason'))
                    ->columnSpanFull()
                    ->prose(),
            ])->columns(2),
        ]);
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('member.user.name')->label(__('admin.reporter'))->searchable(),
                Tables\Columns\BadgeColumn::make('reference_type')
                    ->label(__('admin.type'))
                    ->formatStateUsing(fn ($state) => match ($state) {
                        Listing::class => __('admin.listing'),
                        Member::class  => __('admin.member'),
                        default        => class_basename($state),
                    })
                    ->colors([
                        'warning' => Listing::class,
                        'danger'  => Member::class,
                    ]),
                Tables\Columns\TextColumn::make('report')->limit(60)->label(__('admin.reason')),
                Tables\Columns\BadgeColumn::make('status')
                    ->label(__('admin.status'))
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'accepted',
                        'danger'  => 'rejected',
                    ]),
                Tables\Columns\TextColumn::make('created_at')->label(__('admin.created_at'))->dateTime()->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label(__('admin.status'))
                    ->options(['pending' => __('admin.pending'), 'accepted' => __('admin.approved'), 'rejected' => __('admin.rejected')]),
            ])
            ->actions([
                Actions\Action::make('banListing')
                    ->label(__('admin.ban'))
                    ->icon('heroicon-o-no-symbol')
                    ->color('danger')
                    ->button()
                    ->requiresConfirmation()
                    ->visible(fn (Report $r) => $r->reference_type === Listing::class)
                    ->action(function (Report $record) {
                        $target = $record->reference;
                        if (!$target) {
                            Notification::make()->title('Target not found')->danger()->send();
                            return;
                        }

                        $target->update(['is_banned' => true, 'is_active' => false]);
                        Notification::make()->title('Listing Banned')->danger()->send();

                        $record->update(['status' => 'accepted']);
                    }),
                Actions\Action::make('deactivateMember')
                    ->label(__('admin.deactivate'))
                    ->icon('heroicon-o-user-minus')
                    ->color('danger')
                    ->button()
                    ->requiresConfirmation()
                    ->visible(fn (Report $r) => $r->reference_type === Member::class)
                    ->action(function (Report $record) {
                        $target = $record->reference;
                        if (!$target) {
                            Notification::make()->title('Target not found')->danger()->send();
                            return;
                        }

                        if ($target->user) {
                            $target->user->update(['is_active' => false]);
                            Notification::make()->title('Member Deactivated')->danger()->send();
                        }

                        $record->update(['status' => 'accepted']);
                    }),
                Actions\Action::make('resolve')
                    ->label(__('admin.accept'))
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->button()
                    ->requiresConfirmation()
                    ->visible(fn (Report $r) => $r->status === 'pending')
                    ->action(function (Report $record) {
                        $record->update(['status' => 'accepted']);
                        Notification::make()->title(__('admin.report_accepted'))->success()->send();
                    }),
                Actions\Action::make('dismiss')
                    ->label(__('admin.reject'))
                    ->icon('heroicon-o-x-mark')
                    ->color('danger')
                    ->button()
                    ->requiresConfirmation()
                    ->visible(fn (Report $r) => $r->status === 'pending')
                    ->action(function (Report $record) {
                        $record->update(['status' => 'rejected']);
                        Notification::make()->title(__('admin.report_rejected'))->warning()->send();
                    }),
                Actions\ViewAction::make(),
                Actions\Action::make('viewReference')
                    ->label(__('admin.view_target'))
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->color('info')
                    ->button()
                    ->url(fn (Report $record) => match ($record->reference_type) {
                        Listing::class => ListingResource::getUrl('view', ['record' => $record->reference_id]),
                        Member::class  => MemberResource::getUrl('view', ['record' => $record->reference_id]),
                        default        => null,
                    }),
                Actions\DeleteAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReports::route('/'),
        ];
    }
}
