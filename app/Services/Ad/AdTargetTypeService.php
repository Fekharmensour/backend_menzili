<?php

namespace App\Services\Ad;

use App\Models\Ad;
use Illuminate\Validation\ValidationException;

class AdTargetTypeService
{
    /**
     * Ensure the required target parameter is present for the selected target type.
     */
    public function validateTargetPayload(array $data, ?Ad $ad = null): void
    {
        $isStore = $ad === null;
        $hasTargetTypeInRequest = array_key_exists('target_type', $data);
        $targetType = $data['target_type'] ?? $ad?->target_type;

        if (!$targetType) {
            return;
        }

        // For updates, only enforce when target_type is explicitly sent.
        if (!$isStore && !$hasTargetTypeInRequest) {
            return;
        }

        $requiredField = match ($targetType) {
            'listing' => 'listing_id',
            'member' => 'target_member_id',
            'external' => 'external_url',
            default => null,
        };

        if (!$requiredField) {
            return;
        }

        if (!array_key_exists($requiredField, $data) || blank($data[$requiredField])) {
            throw ValidationException::withMessages([
                $requiredField => [
                    __('api.ad.validation.required_target_parameter', [
                        'field' => $requiredField,
                        'type' => $targetType,
                    ]),
                ],
            ]);
        }
    }

    /**
     * Keep only the target parameter that matches the selected target type.
     */
    public function normalizeTargetPayload(array $data, ?Ad $ad = null): array
    {
        $targetType = $data['target_type'] ?? $ad?->target_type;

        if (!$targetType) {
            return $data;
        }

        if ($targetType !== 'listing') {
            $data['listing_id'] = null;
        }

        if ($targetType !== 'member') {
            $data['target_member_id'] = null;
        }

        if ($targetType !== 'external') {
            $data['external_url'] = null;
        }

        return $data;
    }
}
