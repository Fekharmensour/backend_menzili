<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReviewResource\Pages;
use App\Models\Review;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Actions;
use Filament\Tables\Table;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-star';
    protected static string | \UnitEnum | null $navigationGroup = null;
    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): ?string
    {
        return __('admin.moderation');
    }

    public static function getNavigationLabel(): string
    {
        return __('admin.reviews');
    }

    public static function getModelLabel(): string
    {
        return __('admin.review');
    }

    public static function getPluralModelLabel(): string
    {
        return __('admin.reviews');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label(__('admin.id'))->sortable(),
                Tables\Columns\TextColumn::make('member.user.name')->label(__('admin.reviewer'))->searchable(),
                Tables\Columns\TextColumn::make('listing.title')->label(__('admin.listing'))->limit(30)->searchable(),
                Tables\Columns\TextColumn::make('rating')
                    ->label(__('admin.rating'))
                    ->badge()
                    ->color(fn ($state) => match (true) {
                        $state >= 4  => 'success',
                        $state >= 3  => 'warning',
                        default      => 'danger',
                    }),
                Tables\Columns\TextColumn::make('review')->limit(60)->label(__('admin.comment')),
                Tables\Columns\TextColumn::make('created_at')->label(__('admin.created_at'))->dateTime()->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('rating')
                    ->label(__('admin.rating'))
                    ->options(['1' => '1★', '2' => '2★', '3' => '3★', '4' => '4★', '5' => '5★']),
            ])
            ->actions([
                Actions\DeleteAction::make()
                    ->after(function (Review $record) {
                        $record->listing?->updateRating();
                        Notification::make()->title(__('admin.review_deleted'))->success()->send();
                    }),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReviews::route('/'),
        ];
    }
}
