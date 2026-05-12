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

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-flag';
    protected static string | \UnitEnum | null $navigationGroup = null;
    protected static ?int $navigationSort = 1;

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
                Actions\Action::make('viewReference')
                    ->label(__('admin.view_target'))
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->url(fn (Report $record) => match ($record->reference_type) {
                        Listing::class => ListingResource::getUrl('view', ['record' => $record->reference_id]),
                        Member::class  => MemberResource::getUrl('view', ['record' => $record->reference_id]),
                        default        => null,
                    }),
                Actions\Action::make('resolve')
                    ->label(__('admin.accept'))
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
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
                    ->requiresConfirmation()
                    ->visible(fn (Report $r) => $r->status === 'pending')
                    ->action(function (Report $record) {
                        $record->update(['status' => 'rejected']);
                        Notification::make()->title(__('admin.report_rejected'))->warning()->send();
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
