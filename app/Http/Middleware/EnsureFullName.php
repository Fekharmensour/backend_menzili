<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureFullName
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || blank($user->name)) {
            return response()->json([
                'success' => false,
                'message' => __('profile.must_complete_profile'),
                'status'  => 403
            ], 403);
        }

        return $next($request);
    }
}
