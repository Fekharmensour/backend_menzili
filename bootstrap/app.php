<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
        $middleware->alias([
            'skip.localization.docs'  => \App\Http\Middleware\SkipLocalizationForDocs::class,
            'localize'                => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
            'localeSessionRedirect'   => \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
            'localeCookieRedirect'    => \Mcamara\LaravelLocalization\Middleware\LocaleCookieRedirect::class,
            'localeViewPath'          => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class,
            'localizationRedirect'    => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
            'api.localize'            => \App\Http\Middleware\ApiLocalization::class,
            'fill_name'               => \App\Http\Middleware\EnsureFullName::class,

        ]);

        $middleware->api(append: [
            'api.localize',
        ]);

        $middleware->web(append: [
            'skip.localization.docs',      // MUST BE FIRST to run before redirect logic
            'localize',
            'localeSessionRedirect',
            'localizationRedirect',
        ]);

//        $middleware->encryptCookies(except: ['appearance', 'sidebar_state']);
//
//        $middleware->web(append: [
//            \App\Http\Middleware\HandleAppearance::class,
//            \App\Http\Middleware\HandleInertiaRequests::class,
//            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
//        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
