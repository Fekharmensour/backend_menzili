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

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Components\Section::make('Ad Info')->schema([
                FormComponents\TextInput::make('title')->required()->maxLength(255)->columnSpanFull(),
                FormComponents\Textarea::make('description')->rows(3)->columnSpanFull(),
                FormComponents\TextInput::make('external_url')->url()->label('External URL')->columnSpanFull(),
                FormComponents\FileUpload::make('image_path')->image()->disk('public')->directory('ads')->columnSpanFull(),
            ]),
            Components\Section::make('Settings')->schema([
                FormComponents\Select::make('target_type')
                    ->options(['listing' => 'Listing', 'member' => 'Member', 'external' => 'External'])
                    ->required(),
                FormComponents\Select::make('status')
                    ->options(['pending' => 'Pending', 'active' => 'Active', 'inactive' => 'Inactive', 'rejected' => 'Rejected'])
                    ->required(),
                FormComponents\Select::make('ads_plan_id')
                    ->label(__('admin.ad_plan'))
                    ->relationship('adsPlan', 'name')
                    ->required(),
                FormComponents\DatePicker::make('start_date'),
                FormComponents\DatePicker::make('end_date'),
            ])->columns(2),
        ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Components\Section::make('Ad Creative')->schema([
                InfolistComponents\ImageEntry::make('image_path')
                    ->label('Banner')
                    ->disk('public')
                    ->getStateUsing(fn (Ad $record) => str_replace('/storage/', '', $record->image_path))
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
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('Banner')
                    ->disk('public')
                    ->getStateUsing(fn (Ad $record) => str_replace('/storage/', '', $record->image_path)),
                Tables\Columns\TextColumn::make('title')->searchable()->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'active',
                        'gray'    => 'inactive',
                        'danger'  => 'rejected',
                    ]),
                Tables\Columns\TextColumn::make('adsPlan.name')
                    ->label(__('admin.ad_plan'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_date')->date()->sortable()->toggleable(),
                Tables\Columns\TextColumn::make('end_date')->date()->sortable()->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(['pending' => 'Pending', 'active' => 'Active', 'inactive' => 'Inactive', 'rejected' => 'Rejected']),
                Tables\Filters\SelectFilter::make('target_type')
                    ->options(['listing' => 'Listing', 'member' => 'Member', 'external' => 'External']),
            ])
            ->actions([
                Actions\EditAction::make(),
                Actions\Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (Ad $r) => $r->status === 'pending')
                    ->action(function (Ad $record) {
                        $record->update(['status' => 'active']);
                        Notification::make()->title('Ad approved')->success()->send();
                    }),
                Actions\Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn (Ad $r) => $r->status === 'pending')
                    ->action(function (Ad $record) {
                        $record->update(['status' => 'rejected']);
                        Notification::make()->title('Ad rejected')->danger()->send();
                    }),
                Actions\Action::make('toggleActive')
                    ->label(fn (Ad $r) => $r->status === 'active' ? 'Deactivate' : 'Activate')
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
