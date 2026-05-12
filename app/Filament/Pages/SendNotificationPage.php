<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\NotificationStatsWidget;
use App\Models\Notification;
use App\Models\User;
use App\Models\Wilaya;
use App\Services\Notification\NotificationService;
use Filament\Forms\Components as FormComponents;
use Filament\Schemas\Components as SchemaComponents;
use Filament\Notifications\Notification as FilamentNotification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class SendNotificationPage extends Page implements HasTable
{
    use InteractsWithTable;

    protected string $view = 'filament.pages.send-notification-page';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-paper-airplane';
    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return __('admin.tools');
    }

    public static function getNavigationLabel(): string
    {
        return __('admin.send_notification');
    }

    public function getTitle(): string
    {
        return __('admin.send_notification');
    }

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(['scope' => 'all']);
    }

    protected function getHeaderWidgets(): array
    {
        return [
            NotificationStatsWidget::class,
        ];
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                SchemaComponents\Section::make(__('admin.notification_audience'))
                    ->description(__('admin.notification_audience_desc'))
                    ->icon('heroicon-o-users')
                    ->extraAttributes(['class' => 'mb-12'])
                    ->schema([
                        FormComponents\Select::make('scope')
                            ->label(__('admin.audience'))
                            ->options([
                                'all'     => __('admin.all_users'),
                                'wilaya'  => __('admin.by_wilaya'),
                                'members' => __('admin.specific_members'),
                            ])
                            ->required()
                            ->live()
                            ->default('all'),

                        FormComponents\Select::make('wilaya_id')
                            ->label(__('admin.wilaya'))
                            ->options(\App\Models\Wilaya::orderBy('name_en')->pluck('name_en', 'id'))
                            ->searchable()
                            ->visible(fn ($get) => $get('scope') === 'wilaya')
                            ->required(fn ($get) => $get('scope') === 'wilaya'),

                        // Changed from user_id to member_ids (multiple)
                        FormComponents\Select::make('member_ids')
                            ->label(__('admin.members'))
                            ->options(\App\Models\Member::with('user')->get()->pluck('user.name', 'user_id'))
                            ->searchable()
                            ->multiple()
                            ->preload()
                            ->visible(fn ($get) => $get('scope') === 'members')
                            ->required(fn ($get) => $get('scope') === 'members'),
                    ])->columns(3),

                SchemaComponents\Section::make(__('admin.notification_content'))
                    ->description(__('admin.notification_content_desc'))
                    ->icon('heroicon-o-language')
                    ->extraAttributes(['class' => 'mb-12'])
                    ->schema([
                        FormComponents\TextInput::make('title_ar')
                            ->label('🇩🇿 ' . __('admin.title_ar'))
                            ->required()
                            ->placeholder(__('admin.title_placeholder')),

                        FormComponents\TextInput::make('title_en')
                            ->label('🇺🇸 ' . __('admin.title_en'))
                            ->required()
                            ->placeholder(__('admin.title_placeholder')),

                        FormComponents\TextInput::make('title_fr')
                            ->label('🇫🇷 ' . __('admin.title_fr'))
                            ->required()
                            ->placeholder(__('admin.title_placeholder')),

                        FormComponents\Textarea::make('body_ar')
                            ->label('🇩🇿 ' . __('admin.message_ar'))
                            ->required()
                            ->rows(3)
                            ->placeholder(__('admin.message_placeholder')),

                        FormComponents\Textarea::make('body_en')
                            ->label('🇺🇸 ' . __('admin.message_en'))
                            ->required()
                            ->rows(3)
                            ->placeholder(__('admin.message_placeholder')),

                        FormComponents\Textarea::make('body_fr')
                            ->label('🇫🇷 ' . __('admin.message_fr'))
                            ->required()
                            ->rows(3)
                            ->placeholder(__('admin.message_placeholder')),
                    ])->columns(3),
            ])
            ->statePath('data');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Notification::query()->latest())
            ->columns([
                TextColumn::make('user.name')
                    ->label(__('admin.user'))
                    ->placeholder(__('admin.all_users'))
                    ->searchable(),
                
                TextColumn::make('title_en')
                    ->label(__('admin.title'))
                    ->limit(30)
                    ->searchable(),

                TextColumn::make('body_en')
                    ->label(__('admin.message'))
                    ->limit(50),

                IconColumn::make('is_read')
                    ->label(__('admin.read'))
                    ->boolean()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label(__('admin.date'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginated([5, 10, 25]);
    }

    public function submit(): void
    {
        $payload = $this->form->getState();
        $service = app(NotificationService::class);

        $titles = ['ar' => $payload['title_ar'], 'en' => $payload['title_en'], 'fr' => $payload['title_fr']];
        $bodies = ['ar' => $payload['body_ar'],  'en' => $payload['body_en'],  'fr' => $payload['body_fr']];

        if ($payload['scope'] === 'all') {
            $service->broadcastAll($titles, $bodies);
        } elseif ($payload['scope'] === 'members') {
            $userIds = (array) ($payload['member_ids'] ?? []);
            $users = \App\Models\User::whereIn('id', $userIds)->get();
            foreach ($users as $user) {
                $service->send($user, $titles, $bodies);
            }
        } elseif ($payload['scope'] === 'wilaya') {
            $users = User::whereHas('member.listings', fn ($q) => $q->where('wilaya_id', $payload['wilaya_id']))->get();
            foreach ($users as $user) {
                $service->send($user, $titles, $bodies);
            }
        }

        FilamentNotification::make()
            ->title(__('admin.notification_sent_success'))
            ->success()
            ->send();

        $this->form->fill(['scope' => 'all']);
    }

    protected function getFormActions(): array
    {
        return [
            $this->getSubmitFormAction(),
        ];
    }

    protected function getSubmitFormAction(): \Filament\Actions\Action
    {
        return \Filament\Actions\Action::make('submit')
            ->label(__('admin.send_notification_now'))
            ->submit('form')
            ->icon('heroicon-o-paper-airplane');
    }
}
