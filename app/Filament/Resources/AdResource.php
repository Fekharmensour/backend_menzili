<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdResource\Pages;
use App\Models\Ad;
use Filament\Forms\Components as FormComponents;
use Filament\Infolists\Components as InfolistComponents;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Components;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Actions;
use Filament\Tables\Table;

class AdResource extends Resource
{
    protected static ?string $model = Ad::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-megaphone';
    protected static string | \UnitEnum | null $navigationGroup = null;
    protected static ?int $navigationSort = 4;

    public static function getNavigationGroup(): ?string
    {
        return __('admin.finance');
    }
    public static function getNavigationLabel(): string
    {
        return __('admin.ads');
    }
    public static function getModelLabel(): string
    {
        return __('admin.ad');
    }
    public static function getPluralModelLabel(): string
    {
        return __('admin.ads');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Components\Section::make(__('admin.ad_info'))->schema([
                FormComponents\TextInput::make('title')->required()->maxLength(255)->columnSpanFull(),
                FormComponents\Textarea::make('description')->rows(3)->columnSpanFull(),
                FormComponents\TextInput::make('external_url')->url()->label(__('admin.external_url'))->columnSpanFull(),
                FormComponents\FileUpload::make('image_path')->image()->disk('public')->directory('ads')->columnSpanFull(),
            ]),
            Components\Section::make(__('admin.settings'))->schema([
                FormComponents\Select::make('target_type')
                    ->options(['listing' => __('admin.listing'), 'member' => __('admin.member'), 'external' => 'External'])
                    ->required(),
                FormComponents\Select::make('status')
                    ->options(['pending' => __('admin.pending'), 'active' => __('admin.active'), 'inactive' => 'Inactive', 'rejected' => __('admin.rejected')])
                    ->required(),
                FormComponents\Select::make('ads_plan_id')
                    ->label(__('admin.ad_plan'))
                    ->relationship('adsPlan', 'id')
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->name_en)
                    ->required(),
                FormComponents\DatePicker::make('start_date'),
                FormComponents\DatePicker::make('end_date'),
            ])->columns(2),
        ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Components\Section::make(__('admin.ad_creative'))->schema([
                InfolistComponents\ImageEntry::make('image_path')
                    ->label(__('admin.banner'))
                    ->disk('public')
                    ->height(300)
                    ->columnSpanFull(),
            ]),
            Components\Section::make('Details')->schema([
                InfolistComponents\TextEntry::make('title'),
                InfolistComponents\TextEntry::make('status'),
                InfolistComponents\TextEntry::make('target_type'),
                InfolistComponents\TextEntry::make('external_url'),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label(__('admin.id'))->sortable(),
                Tables\Columns\ImageColumn::make('image_path')
                    ->label(__('admin.banner'))
                    ->disk('public'),
                Tables\Columns\TextColumn::make('title')->label(__('admin.title'))->searchable()->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label(__('admin.status'))
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'active',
                        'gray'    => 'inactive',
                        'danger'  => 'rejected',
                    ]),
                Tables\Columns\TextColumn::make('adsPlan.name_en')
                    ->label(__('admin.ad_plan'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_date')->label(__('admin.start_date'))->date()->sortable()->toggleable(),
                Tables\Columns\TextColumn::make('end_date')->label(__('admin.end_date'))->date()->sortable()->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(['pending' => __('admin.pending'), 'active' => __('admin.active'), 'inactive' => 'Inactive', 'rejected' => __('admin.rejected')]),
                Tables\Filters\SelectFilter::make('target_type')
                    ->options(['listing' => __('admin.listing'), 'member' => __('admin.member'), 'external' => 'External']),
            ])
            ->actions([
                Actions\EditAction::make(),
                Actions\Action::make('approve')
                    ->label(__('admin.approve'))
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (Ad $r) => $r->status === 'pending')
                    ->action(function (Ad $record) {
                        $record->update(['status' => 'active']);
                        Notification::make()->title(__('admin.ad_approved'))->success()->send();
                    }),
                Actions\Action::make('reject')
                    ->label(__('admin.reject'))
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn (Ad $r) => $r->status === 'pending')
                    ->action(function (Ad $record) {
                        $record->update(['status' => 'rejected']);
                        Notification::make()->title(__('admin.ad_rejected'))->danger()->send();
                    }),
                Actions\Action::make('toggleActive')
                    ->label(fn (Ad $r) => $r->status === 'active' ? __('admin.deactivate') : __('admin.activate'))
                    ->color(fn (Ad $r) => $r->status === 'active' ? 'warning' : 'success')
                    ->icon('heroicon-o-power')
                    ->visible(fn (Ad $r) => in_array($r->status, ['active', 'inactive']))
                    ->action(fn (Ad $r) => $r->update(['status' => $r->status === 'active' ? 'inactive' : 'active'])),
                Actions\DeleteAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAds::route('/'),
            'create' => Pages\CreateAd::route('/create'),
            'edit'  => Pages\EditAd::route('/{record}/edit'),
        ];
    }
}
