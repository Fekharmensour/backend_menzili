<?php

namespace App\Http\Requests\Ad;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',

            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',

            'target_type' => 'sometimes|in:listing,member,external',

            'listing_id' => 'nullable|exists:listings,id',
            'target_member_id' => 'nullable|exists:members,id',
            'external_url' => 'nullable|url',

            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date|after_or_equal:start_date',

            'status' => 'sometimes|in:active,paused,expired',
            'coins' => 'nullable|integer|min:0',
        ];
    }
}
