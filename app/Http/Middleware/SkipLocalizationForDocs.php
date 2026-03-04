<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Symfony\Component\HttpFoundation\Response;

class SkipLocalizationForDocs
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the current path starts with docs/api
        if ($request->is('docs/api*')) {
            // This is a "hack" to tell Mcamara's package to ignore this request
            // if the config setting isn't catching it.
            $request->route()?->forgetParameter('locale');

            return $next($request);
        }

        return $next($request);
    }
}
