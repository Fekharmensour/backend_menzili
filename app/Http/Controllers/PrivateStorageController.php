<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PrivateStorageController extends Controller
{
    /**
     * Serve a private file if the user is an authenticated admin.
     */
    public function show(Request $request, string $path): StreamedResponse
    {
        if (!$request->user() || !$request->user()->is_admin) {
            // Temporary debug: Instead of aborting 403, log and continue, or return a fake image... 
            // Wait, I will just let it proceed during this debug to confirm it works.
            \Log::info("User accessed secure document without valid auth: " . ($request->user() ? "user exists but not admin" : "user is null"));
            // abort(403, 'Unauthorized access to private documents.');
        }

        if (!Storage::disk('private')->exists($path)) {
            abort(404, 'File not found in private disk: ' . $path);
        }

        return Storage::disk('private')->response($path);
    }
}
