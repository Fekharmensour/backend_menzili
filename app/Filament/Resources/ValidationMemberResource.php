<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ValidationMemberResource\Pages;
use App\Models\Member;
use Filament\Forms\Components as FormComponents;
use Filament\Infolists\Components as InfolistComponents;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Components;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Actions;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ValidationMemberResource extends Resource
{
    protected static ?string $model = Member::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-check-badge';
    protected static ?int $navigationSort = 3;

    public static function getNavigationGroup(): ?string
    {
        return __('admin.users');
    }

    public static function getNavigationLabel(): string
    {
        return __('admin.validation_members');
    }

    public static function getModelLabel(): string
    {
        return __('admin.validation_member');
    }

    public static function getPluralModelLabel(): string
    {
        return __('admin.validation_members');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes()
            ->where(function (Builder $query) {
                $query->where(function ($q) {
                    $q->whereNull('member_verified_at')
                        ->whereNotNull('card_id_front_path');
                })->orWhere(function ($q) {
                    $q->whereNull('agent_verified_at')
                        ->whereNotNull('document_path');
                });
            });
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Components\Section::make(__('admin.user_info'))->schema([
                InfolistComponents\TextEntry::make('user.name')->label(__('admin.name')),
                InfolistComponents\TextEntry::make('user.phone')->label(__('admin.phone')),
                InfolistComponents\TextEntry::make('user.email')->label(__('admin.email')),
            ])->columns(3)->columnSpanFull(),

            Components\Section::make(__('admin.identification_documents'))
                ->schema([
                    InfolistComponents\TextEntry::make('identity_status')
                        ->label(__('admin.status'))
                        ->badge()
                        ->color(fn ($state) => match ($state) {
                            'pending' => 'warning',
                            'approved' => 'success',
                            'rejected' => 'danger',
                            default => 'gray',
                        })
                        ->formatStateUsing(fn ($state) => __("admin.{$state}"))
                        ->columnSpanFull(),
                    InfolistComponents\TextEntry::make('identity_rejection_reason')
                        ->label(__('admin.description'))
                        ->color('danger')
                        ->columnSpanFull()
                        ->visible(fn ($record) => $record->identity_status === Member::STATUS_REJECTED && filled($record->identity_rejection_reason)),

                    InfolistComponents\ImageEntry::make('card_id_front_path')
                        ->label(__('admin.id_card_front'))
                        ->state(fn ($record) => $record && $record->card_id_front_path ? route('private.storage', ['path' => $record->card_id_front_path]) : null)
                        ->height(400)
                        ->action(
                            \Filament\Actions\Action::make('view_front')
                                ->modalHeading(__('admin.id_card_front'))
                                ->modalContent(fn ($record) => $record ? new \Illuminate\Support\HtmlString('<img src="' . route('private.storage', ['path' => $record->card_id_front_path]) . '" style="width: 100%; height: auto;">') : null)
                                ->modalSubmitAction(false)
                                ->modalCancelAction(false)
                        )
                        ->visible(fn ($record) => $record && filled($record->card_id_front_path)),
                    InfolistComponents\ImageEntry::make('card_id_back_path')
                        ->label(__('admin.id_card_back'))
                        ->state(fn ($record) => $record && $record->card_id_back_path ? route('private.storage', ['path' => $record->card_id_back_path]) : null)
                        ->height(400)
                        ->action(
                            \Filament\Actions\Action::make('view_back')
                                ->modalHeading(__('admin.id_card_back'))
                                ->modalContent(fn ($record) => $record ? new \Illuminate\Support\HtmlString('<img src="' . route('private.storage', ['path' => $record->card_id_back_path]) . '" style="width: 100%; height: auto;">') : null)
                                ->modalSubmitAction(false)
                                ->modalCancelAction(false)
                        )
                        ->visible(fn ($record) => $record && filled($record->card_id_back_path)),
                ])->columns(2)
                ->columnSpanFull()
                ->visible(fn ($record) => $record && filled($record->card_id_front_path)),

            Components\Section::make(__('admin.professional_document'))
                ->schema([
                    InfolistComponents\TextEntry::make('agent_status')
                        ->label(__('admin.status'))
                        ->badge()
                        ->color(fn ($state) => match ($state) {
                            'pending' => 'warning',
                            'approved' => 'success',
                            'rejected' => 'danger',
                            default => 'gray',
                        })
                        ->formatStateUsing(fn ($state) => __("admin.{$state}"))
                        ->columnSpanFull(),
                    InfolistComponents\TextEntry::make('agent_rejection_reason')
                        ->label(__('admin.description'))
                        ->color('danger')
                        ->columnSpanFull()
                        ->visible(fn ($record) => $record->agent_status === Member::STATUS_REJECTED && filled($record->agent_rejection_reason)),
                    InfolistComponents\TextEntry::make('document_path_pdf')
                        ->label(__('admin.document'))
                        ->state(fn ($record) => $record?->document_path)
                        ->formatStateUsing(fn ($state) => new \Illuminate\Support\HtmlString('<iframe src="' . route('private.storage', ['path' => $state]) . '" style="width: 100%; height: 800px; border: none; border-radius: 8px;"></iframe>'))
                        ->html()
                        ->columnSpanFull()
                        ->visible(fn ($record) => $record && str_ends_with(strtolower($record->document_path ?? ''), '.pdf')),
                    
                    InfolistComponents\ImageEntry::make('document_path')
                        ->label(__('admin.document'))
                        ->state(fn ($record) => $record && !str_ends_with(strtolower($record->document_path ?? ''), '.pdf') && filled($record->document_path) ? route('private.storage', ['path' => $record->document_path]) : null)
                        ->height(600)
                        ->action(
                            \Filament\Actions\Action::make('view_doc')
                                ->modalHeading(__('admin.document'))
                                ->modalContent(fn ($record) => $record ? new \Illuminate\Support\HtmlString('<img src="' . route('private.storage', ['path' => $record->document_path]) . '" style="width: 100%; height: auto;">') : null)
                                ->modalSubmitAction(false)
                                ->modalCancelAction(false)
                        )
                        ->columnSpanFull()
                        ->visible(fn ($record) => $record && !str_ends_with(strtolower($record->document_path ?? ''), '.pdf') && filled($record->document_path)),
                ])
                ->columnSpanFull()
                ->visible(fn ($record) => $record && filled($record->document_path)),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('user.profile_image')
                    ->label(__('admin.photo'))
                    ->disk('public')
                    ->getStateUsing(fn ($record) => $record && $record->user->profile_image ? str_replace('/storage/', '', $record->user->profile_image) : null)
                    ->defaultImageUrl(fn ($record) => $record ? "https://ui-avatars.com/api/?name=" . urlencode($record->user->name) . "&background=0078fd&color=fff&bold=true" : null)
                    ->circular(),
                Tables\Columns\TextColumn::make('user.name')->label(__('admin.name'))->searchable()->sortable(),
                Tables\Columns\TextColumn::make('user.phone')->label(__('admin.phone'))->searchable(),

                Tables\Columns\TextColumn::make('status')
                    ->label(__('admin.status'))
                    ->badge()
                    ->getStateUsing(function (Member $record) {
                        return $record->identity_status !== Member::STATUS_APPROVED 
                            ? $record->identity_status 
                            : $record->agent_status;
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        'unsubmitted' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => __("admin.{$state}")),

                Tables\Columns\TextColumn::make('verification_type')
                    ->label(__('admin.verification_type'))
                    ->badge()
                    ->getStateUsing(function (Member $record) {
                        if ($record->identity_status !== Member::STATUS_APPROVED && filled($record->card_id_front_path)) {
                            return 'identity';
                        }
                        if ($record->agent_status !== Member::STATUS_APPROVED && filled($record->document_path)) {
                            return 'agent';
                        }
                        return null;
                    })
                    ->color(fn (?string $state): string => match ($state) {
                        'identity' => 'info',
                        'agent' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (?string $state): string => $state ? __("admin.{$state}") : '-'),
                
                Tables\Columns\TextColumn::make('identity_status')
                    ->label(__('admin.identity'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'unsubmitted' => 'gray',
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                    })
                    ->formatStateUsing(fn (string $state): string => __("admin.{$state}"))
                    ->visible(fn ($record) => $record && filled($record->card_id_front_path)),
                
                Tables\Columns\TextColumn::make('agent_status')
                    ->label(__('admin.agent'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'unsubmitted' => 'gray',
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                    })
                    ->formatStateUsing(fn (string $state): string => __("admin.{$state}"))
                    ->visible(fn ($record) => $record && filled($record->document_path)),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('admin.date'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                Actions\ViewAction::make(),
                Actions\Action::make('approve')
                    ->label(__('admin.approve'))
                    ->color('success')
                    ->icon('heroicon-o-check-circle')
                    ->visible(fn (Member $record) => 
                        ($record->identity_status !== Member::STATUS_APPROVED && filled($record->card_id_front_path)) ||
                        ($record->identity_status === Member::STATUS_APPROVED && $record->agent_status !== Member::STATUS_APPROVED && filled($record->document_path))
                    )
                    ->requiresConfirmation()
                    ->action(function (Member $record) {
                        if ($record->identity_status !== Member::STATUS_APPROVED) {
                            $record->update([
                                'member_verified_at' => now(),
                                'identity_status' => Member::STATUS_APPROVED,
                                'identity_rejection_reason' => null,
                            ]);
                            $title = __('admin.identity_approved');
                        } else {
                            $record->update([
                                'agent_verified_at' => now(),
                                'agent_status' => Member::STATUS_APPROVED,
                                'agent_rejection_reason' => null,
                            ]);
                            $title = __('admin.agent_approved');
                        }
                        Notification::make()->title($title)->success()->send();
                    }),
                Actions\Action::make('reject')
                    ->label(__('admin.reject'))
                    ->color('danger')
                    ->icon('heroicon-o-x-circle')
                    ->visible(fn (Member $record) => 
                        ($record->identity_status !== Member::STATUS_APPROVED && filled($record->card_id_front_path)) ||
                        ($record->identity_status === Member::STATUS_APPROVED && $record->agent_status !== Member::STATUS_APPROVED && filled($record->document_path))
                    )
                    ->form([
                        FormComponents\Textarea::make('reason')
                            ->label(__('admin.description'))
                            ->required(),
                    ])
                    ->action(function (Member $record, array $data) {
                        if ($record->identity_status !== Member::STATUS_APPROVED) {
                            $record->update([
                                'member_verified_at' => null,
                                'identity_status' => Member::STATUS_REJECTED,
                                'identity_rejection_reason' => $data['reason'],
                            ]);
                        } else {
                            $record->update([
                                'agent_verified_at' => null,
                                'agent_status' => Member::STATUS_REJECTED,
                                'agent_rejection_reason' => $data['reason'],
                            ]);
                        }
                        Notification::make()->title(__('admin.rejected'))->danger()->send();
                    }),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListValidationMembers::route('/'),
            'view' => Pages\ViewValidationMember::route('/{record}'),
        ];
    }
}
