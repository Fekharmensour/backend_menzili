<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ListingResource\Pages;
use App\Filament\Resources\ListingResource\RelationManagers;
use App\Models\Listing;
use Filament\Forms\Components as FormComponents;
use Filament\Infolists\Components as InfolistComponents;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Components;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Actions;
use Filament\Tables\Table;
use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Support\Str;

class ListingResource extends Resource
{
    protected static ?string $model = Listing::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-home';
    protected static string | \UnitEnum | null $navigationGroup = null;
    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return __('admin.listings');
    }

    public static function getNavigationLabel(): string
    {
        return __('admin.listings');
    }

    public static function getModelLabel(): string
    {
        return __('admin.listing');
    }

    public static function getPluralModelLabel(): string
    {
        return __('admin.listings');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Components\Section::make(__('admin.basic_info'))->schema([
                FormComponents\TextInput::make('title')
                    ->label(__('admin.title'))
                    ->required()->maxLength(255)->columnSpanFull(),
                FormComponents\Textarea::make('description')
                    ->label(__('admin.description'))
                    ->rows(4)->columnSpanFull(),
                FormComponents\FileUpload::make('main_image')
                    ->label(__('admin.main_image'))
                    ->image()
                    ->disk('public')
                    ->directory('listings')
                    ->imageEditor()
                    ->openable()
                    ->downloadable()
                    ->formatStateUsing(fn ($state) => str_replace('/storage/', '', $state))
                    ->columnSpanFull(),
                FormComponents\Select::make('location_id')
                    ->label(__('admin.city'))
                    ->relationship('location', 'id')
                    ->getOptionLabelFromRecordUsing(fn ($record) => optional($record->city)->name ?? "ID: {$record->id}")
                    ->searchable()
                    ->required(),
                FormComponents\TextInput::make('price')
                    ->label(__('admin.price'))
                    ->numeric(),
                FormComponents\TextInput::make('surface')
                    ->label(__('admin.surface'))
                    ->numeric(),
                FormComponents\TextInput::make('floor')
                    ->label(__('admin.floor'))
                    ->numeric(),
                FormComponents\TextInput::make('number_rooms')
                    ->label(__('admin.rooms'))
                    ->numeric(),
                FormComponents\TextInput::make('number_persons')
                    ->label(__('admin.persons'))
                    ->numeric(),
            ])->columns(2),
            Components\Section::make(__('admin.status'))->schema([
                FormComponents\Select::make('member_id')
                    ->label(__('admin.member'))
                    ->relationship('member', 'id')
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->user->name)
                    ->searchable()
                    ->required(),
                FormComponents\Select::make('type_id')
                    ->label(__('admin.type'))
                    ->relationship('type', 'name_en')
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->name)
                    ->required()
                    ->live(),
                FormComponents\Select::make('rent_duration_id')
                    ->label(__('admin.rent_duration'))
                    ->relationship('rentDuration', 'name_en')
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->name)
                    ->visible(fn (Get $get) => Str::contains(optional(\App\Models\Type::find($get('type_id')))->name_en, 'Rent', true)),
                FormComponents\Select::make('moderation_status')
                    ->label(__('admin.moderation_status'))
                    ->options([
                        'pending' => __('admin.pending'),
                        'approved' => __('admin.approved'),
                        'rejected' => __('admin.rejected'),
                    ]),
                FormComponents\Toggle::make('is_active')->label(__('admin.active')),
                FormComponents\Toggle::make('is_ready')->label(__('admin.ready')),
                FormComponents\Toggle::make('is_negotiable')->label(__('admin.negotiable')),
                FormComponents\DateTimePicker::make('verified_at')->label(__('admin.verified_at')),
            ])->columns(2),
            Components\Section::make(__('admin.property_details'))->schema([
                FormComponents\Repeater::make('images')
                    ->label(__('admin.gallery'))
                    ->relationship('images')
                    ->schema([
                        FormComponents\FileUpload::make('path')
                            ->label(__('admin.image'))
                            ->image()
                            ->disk('public')
                            ->directory('listings/gallery')
                            ->imageEditor()
                            ->openable()
                            ->downloadable()
                            ->formatStateUsing(fn ($state) => str_replace('/storage/', '', $state))
                            ->required(),
                    ])
                    ->grid(3)
                    ->columnSpanFull(),
                FormComponents\CheckboxList::make('features')
                    ->label(__('admin.features'))
                    ->relationship('features', 'name_en')
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->name)
                    ->columns(3),
                FormComponents\CheckboxList::make('nearPlaces')
                    ->label(__('admin.near_places'))
                    ->relationship('nearPlaces', 'name_en')
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->name)
                    ->columns(3),
            ]),
        ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Components\Section::make(__('admin.basic_info'))->schema([
                Components\Grid::make(3)->schema([
                    InfolistComponents\ImageEntry::make('main_image')
                        ->label(__('admin.main_image'))
                        ->disk('public')
                        ->getStateUsing(fn (Listing $record) => str_replace('/storage/', '', $record->main_image))
                        ->height(250)
                        ->extraImgAttributes([
                            'class' => 'rounded-xl shadow-lg object-cover',
                            'style' => 'max-width: 100%; width: auto; height: 250px;',
                        ])
                        ->columnSpan(1),
                    Components\Grid::make(2)->schema([
                        InfolistComponents\TextEntry::make('title')
                            ->label(__('admin.title'))
                            ->weight('bold')
                            ->size('lg')
                            ->columnSpanFull(),
                        InfolistComponents\TextEntry::make('price')
                            ->label(__('admin.price'))
                            ->money('DZD')
                            ->color('primary')
                            ->weight('bold'),
                        InfolistComponents\TextEntry::make('location.city.name')
                            ->label(__('admin.city')),
                        InfolistComponents\TextEntry::make('type.name_en')
                            ->label(__('admin.type')),
                        InfolistComponents\TextEntry::make('rentDuration.name_en')
                            ->label(__('admin.rent_duration'))
                            ->visible(fn ($record) => $record->rent_duration_id),
                        InfolistComponents\TextEntry::make('member.user.name')
                            ->label(__('admin.owner')),
                    ])->columnSpan(2),
                ]),
            ]),
            Components\Section::make(__('admin.property_details'))->schema([
                Components\Grid::make(4)->schema([
                    InfolistComponents\TextEntry::make('surface')
                        ->label(__('admin.surface'))
                        ->suffix(' m²'),
                    InfolistComponents\TextEntry::make('floor')
                        ->label(__('admin.floor')),
                    InfolistComponents\TextEntry::make('number_rooms')
                        ->label(__('admin.rooms')),
                    InfolistComponents\TextEntry::make('number_persons')
                        ->label(__('admin.persons')),
                ]),
                InfolistComponents\TextEntry::make('description')
                    ->label(__('admin.description'))
                    ->columnSpanFull()
                    ->prose(),
            ]),
            Components\Section::make(__('admin.status'))->schema([
                Components\Grid::make(2)->schema([
                    InfolistComponents\TextEntry::make('moderation_status')
                        ->label(__('admin.status'))
                        ->badge()
                        ->colors([
                            'warning' => 'pending',
                            'success' => 'approved',
                            'danger' => 'rejected',
                        ]),
                    InfolistComponents\TextEntry::make('verified_at')
                        ->label(__('admin.verified_at'))
                        ->dateTime()
                        ->placeholder(__('admin.not_verified')),
                ]),
                Components\Grid::make(3)->schema([
                    InfolistComponents\IconEntry::make('is_active')
                        ->label(__('admin.active'))
                        ->boolean(),
                    InfolistComponents\IconEntry::make('is_ready')
                        ->label(__('admin.ready'))
                        ->boolean(),
                    InfolistComponents\IconEntry::make('is_negotiable')
                        ->label(__('admin.negotiable'))
                        ->boolean(),
                ]),
            ]),
            Components\Section::make(__('admin.features'))->schema([
                InfolistComponents\TextEntry::make('features.name_en')
                    ->label(false)
                    ->badge()
                    ->columnSpanFull(),
            ])->visible(fn ($record) => $record->features->count() > 0),
            Components\Section::make(__('admin.near_places'))->schema([
                InfolistComponents\TextEntry::make('nearPlaces.name_en')
                    ->label(false)
                    ->badge()
                    ->columnSpanFull(),
            ])->visible(fn ($record) => $record->nearPlaces->count() > 0),
            Components\Section::make(__('admin.gallery'))->schema([
                InfolistComponents\ImageEntry::make('images.path')
                    ->label(false)
                    ->disk('public')
                    ->getStateUsing(fn (Listing $record) => $record->images->pluck('path')->map(fn ($p) => str_replace('/storage/', '', $p))->toArray())
                    ->height(120)
                    ->extraImgAttributes([
                        'style' => 'max-width: 100%; width: auto; height: 120px; object-fit: cover;',
                    ])
                    ->columnSpanFull(),
            ])->collapsible(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('main_image')
                    ->label(__('admin.image'))
                    ->disk('public')
                    ->getStateUsing(fn (Listing $record) => str_replace('/storage/', '', $record->main_image))
                    ->circular(),
                Tables\Columns\TextColumn::make('title')
                    ->label(__('admin.title'))
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('member.user.name')
                    ->label(__('admin.owner'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('type.name_en')
                    ->label(__('admin.type')),
                Tables\Columns\TextColumn::make('rentDuration.name_en')
                    ->label(__('admin.rent_duration'))
                    ->toggleable(),
                Tables\Columns\TextColumn::make('features.name_en')
                    ->label(__('admin.features'))
                    ->badge()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('nearPlaces.name_en')
                    ->label(__('admin.near_places'))
                    ->badge()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('price')
                    ->label(__('admin.price'))
                    ->money('DZD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('views')
                    ->label(__('admin.views'))
                    ->sortable()->toggleable(),
                Tables\Columns\TextColumn::make('rating_avg')
                    ->label(__('admin.rating'))
                    ->numeric(2)->sortable()->toggleable(),
                Tables\Columns\BadgeColumn::make('moderation_status')
                    ->label(__('admin.status'))
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ]),
                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('admin.active'))
                    ->boolean(),
                Tables\Columns\IconColumn::make('verified_at')
                    ->label(__('admin.verified'))
                    ->boolean()
                    ->getStateUsing(fn (Listing $r) => !is_null($r->verified_at)),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('admin.created_at'))
                    ->dateTime()->sortable()->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('moderation_status')
                    ->options(['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected']),
                Tables\Filters\TernaryFilter::make('is_active')->label('Active'),
                Tables\Filters\Filter::make('verified')
                    ->label('Verified')
                    ->query(fn ($q) => $q->whereNotNull('verified_at')),
            ])
            ->actions([
                Actions\ViewAction::make(),
                Actions\EditAction::make(),
                Actions\Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (Listing $r) => $r->moderation_status !== 'approved')
                    ->action(function (Listing $record) {
                        $record->update(['moderation_status' => 'approved', 'is_active' => true]);
                        Notification::make()->title('Listing approved')->success()->send();
                    }),
                Actions\Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn (Listing $r) => $r->moderation_status !== 'rejected')
                    ->action(function (Listing $record) {
                        $record->update(['moderation_status' => 'rejected', 'is_active' => false]);
                        Notification::make()->title('Listing rejected')->danger()->send();
                    }),
                Actions\Action::make('verify')
                    ->label('Verify')
                    ->icon('heroicon-o-shield-check')
                    ->color('info')
                    ->requiresConfirmation()
                    ->visible(fn (Listing $r) => is_null($r->verified_at))
                    ->action(function (Listing $record) {
                        $record->update(['verified_at' => now()]);
                        Notification::make()->title('Listing verified')->success()->send();
                    }),
                Actions\Action::make('toggleActive')
                    ->label(fn (Listing $r) => $r->is_active ? 'Deactivate' : 'Activate')
                    ->color(fn (Listing $r) => $r->is_active ? 'warning' : 'success')
                    ->icon('heroicon-o-power')
                    ->requiresConfirmation()
                    ->action(fn (Listing $r) => $r->update(['is_active' => !$r->is_active])),
                Actions\DeleteAction::make()
                    ->action(fn (Listing $r) => $r->deleteWithMedia()),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelationManagers(): array
    {
        return [
            RelationManagers\ImagesRelationManager::class,
            RelationManagers\ReviewsRelationManager::class,
            RelationManagers\ReportsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListListings::route('/'),
            'create' => Pages\CreateListing::route('/create'),
            'view' => Pages\ViewListing::route('/{record}'),
            'edit' => Pages\EditListing::route('/{record}/edit'),
        ];
    }
}
