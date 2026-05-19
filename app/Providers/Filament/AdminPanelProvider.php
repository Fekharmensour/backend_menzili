<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Navigation\MenuItem;
use Filament\Actions\Action;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\HtmlString;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Support\Facades\Blade;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->brandName(fn() => "Menzili")
            ->brandLogo(asset('logo.svg'))
            ->brandLogoHeight('2rem')
            ->login()
            ->profile()
            ->userMenuItems([
                'logout' => Action::make('logout')
                    ->label(fn() => __('admin.logout'))
                    ->icon('heroicon-m-arrow-left-on-rectangle')
                    ->url(fn (): string => filament()->getLogoutUrl())
                    ->postToUrl(),
            ])
            ->renderHook(
                PanelsRenderHook::USER_MENU_BEFORE,
                fn (): string => Blade::render('
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center gap-x-2 px-3 py-2 text-xs font-bold bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-100 dark:border-gray-700 mr-2 shadow-sm transition-colors hover:bg-gray-100 dark:hover:bg-gray-700">
                            @if(app()->getLocale() == "ar")
                                <span>🇩🇿</span> <span class="hidden sm:inline">العربية</span>
                            @elseif(app()->getLocale() == "fr")
                                <span>🇫🇷</span> <span class="hidden sm:inline">Français</span>
                            @else
                                <span>🇺🇸</span> <span class="hidden sm:inline">English</span>
                            @endif

                        </button>
                        <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-40 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-100 dark:border-gray-700 z-50 overflow-hidden">
                            <a href="?locale=ar" class="flex items-center gap-x-3 px-4 py-2 text-sm hover:bg-primary-50 dark:hover:bg-primary-900/20 @if(app()->getLocale() == "ar") text-primary-600 bg-primary-50/50 @endif">
                                <span>🇩🇿</span> العربية
                            </a>
                            <a href="?locale=en" class="flex items-center gap-x-3 px-4 py-2 text-sm hover:bg-primary-50 dark:hover:bg-primary-900/20 @if(app()->getLocale() == "en") text-primary-600 bg-primary-50/50 @endif">
                                <span>🇺🇸</span> English
                            </a>
                            <a href="?locale=fr" class="flex items-center gap-x-3 px-4 py-2 text-sm hover:bg-primary-50 dark:hover:bg-primary-900/20 @if(app()->getLocale() == "fr") text-primary-600 bg-primary-50/50 @endif">
                                <span>🇫🇷</span> Français
                            </a>
                        </div>
                    </div>
                '),
            )
            ->colors([
                'primary' => '#0078fd',
                'secondary' => '#064BCD',
                'info' => '#2fe0d7',
                'success' => Color::Green,
                'warning' => '#FAB845',
                'danger' => Color::Red,
                'gray' => '#6B7280',
            ])
            ->renderHook(
                PanelsRenderHook::HEAD_END,
                fn (): string => '<style>
                    [dir="rtl"] .fi-main-ctn { font-family: "Tajawal", sans-serif; }
                    .fi-btn-color-primary,
                    .fi-btn-color-primary *,
                    .fi-badge-color-primary,
                    .fi-badge-color-primary *,
                    .fi-tabs-item-active,
                    .fi-tabs-item-active * {
                        color: white !important;
                    }
                    /* Fix large images in Wallet Overview */
                    .fi-main-ctn img {
                        max-width: 100%;
                        height: auto;
                    }
                    .fi-main-ctn .fi-section img {
                        max-height: 250px;
                        width: auto;
                        object-fit: contain;
                    }
                    /* Specific fix for Wallet Overview Page Icons */
                    .fi-page-wallet-overview-page .fi-section svg {
                        width: 2rem !important;
                        height: 2rem !important;
                        min-width: 2rem !important;
                        min-height: 2rem !important;
                    }
                    /* Layout and UI Polish */
                    .fi-main-ctn .fi-section {
                        border-radius: 1rem;
                    }
                    /* Center Logout Text in User Menu */
                    .fi-user-menu-item:last-child .fi-dropdown-list-item {
                        justify-content: center;
                    }
                    .fi-user-menu-item:last-child .fi-dropdown-list-item-label {
                        flex: none;
                    }
                </style>' . (app()->getLocale() === 'ar' ? '<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">' : ''),
            )
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
            ])
            ->navigationGroups([
                NavigationGroup::make()->label(fn() => __('admin.users')),
                NavigationGroup::make()->label(fn() => __('admin.listings')),
                NavigationGroup::make()->label(fn() => __('admin.moderation')),
                NavigationGroup::make()->label(fn() => __('admin.finance')),
                NavigationGroup::make()->label(fn() => __('admin.config')),
                NavigationGroup::make()->label(fn() => __('admin.ai')),
                NavigationGroup::make()->label(fn() => __('admin.tools')),
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                \App\Http\Middleware\SetAdminLocale::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
