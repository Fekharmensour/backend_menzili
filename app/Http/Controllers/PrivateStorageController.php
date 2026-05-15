<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class PrivateStorageController extends Controller
{
    /**
     * Serve a private file if the user is an authenticated admin.
     */
    public function show(Request $request): Response
    {
        $path = $request->query('path');

        if (!$path) {
            abort(404, 'No file path provided.');
        }

        // Try to get user from default guard or filament guard
        $user = $request->user() ?? auth('filament')->user();

        if (!$user || !$user->is_admin) {
            \Log::warning("Unauthorized access attempt to secure document: {$path}", [
                'user_id' => $user?->id,
                'ip' => $request->ip()
            ]);
            abort(403, 'Unauthorized access to private documents.');
        }

        if (!Storage::disk('private')->exists($path)) {
            \Log::error("Secure document not found: {$path}");
            abort(404, 'File not found in private disk.');
        }

        return Storage::disk('private')->response($path);
    }
}
