<?php

namespace App\Http\Responses;

use Illuminate\Support\Str;

trait ApiResponseTrait
{
    protected function api(bool $success, string $messageKey, int $status = null, mixed $data = null): \Illuminate\Http\JsonResponse
    {
        $message = __($messageKey);

        if ($status === null) {
            $status = $success ? 200 : 400;
            if (Str::contains($messageKey, ['created', 'store', 'add'])) $status = 201;
            if (Str::contains($messageKey, ['deleted', 'remove'])) $status = 200;
            if (Str::contains($messageKey, ['not_found', 'missing'])) $status = 404;
            if (Str::contains($messageKey, ['unauthorized', 'forbidden'])) $status = 403;
        }

        $payload = [
            'success' => $success,
            'message' => $message,
            'status' => $status,
        ];

        if ($data !== null) {
            $payload['data'] = $data;
        }

        return response()->json($payload, $status);
    }

    protected function apiSuccess(string $messageKey, mixed $data = null, int $status = null): \Illuminate\Http\JsonResponse
    {
        return $this->api(true, $messageKey, $status, $data);
    }

    protected function apiError(string $messageKey, int $status = null, mixed $errors = null): \Illuminate\Http\JsonResponse
    {
        $response = $this->api(false, $messageKey, $status);
        if ($errors !== null) {
            $response->original['errors'] = $errors;
        }
        return $response;
    }
}
