<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetAdminLocale
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->query('locale');

        if ($locale && in_array($locale, ['en', 'ar', 'fr'])) {
            session(['admin_locale' => $locale]);
        }

        if (session()->has('admin_locale')) {
            app()->setLocale(session('admin_locale'));
        }

        return $next($request);
    }
}
