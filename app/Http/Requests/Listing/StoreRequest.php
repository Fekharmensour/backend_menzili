<?php

namespace App\Http\Requests\Listing;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
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

            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],

            // Price & Property Info
            'price' => ['required', 'numeric', 'min:0'],
            'floor' => ['nullable', 'integer', 'min:0'],
            'surface' => ['required', 'numeric', 'min:0'],
            'boost_level'=> ['nullable', 'integer', 'min:1', 'max:10'],
            'min_duration' => ['nullable', 'integer', 'min:1'],
            'number_rooms' => ['nullable', 'integer', 'min:1'],
            'number_persons' => ['nullable', 'integer', 'min:1'],

            // Booleans

            'is_ready' => ['sometimes', 'boolean'],
            'is_negotiable' => ['sometimes', 'boolean'],

            // Enum
//            'moderation_status' => [
//                'sometimes',
//                Rule::in(['pending', 'approved', 'rejected'])
//            ],

            // Image
            'main_image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],

            // Foreign Keys
            'member_id' => ['required', 'exists:members,id'],
            'rent_duration_id' => ['required', 'exists:rent_durations,id'],
            'type_id' => ['required', 'exists:types,id'],

            //location
            'location' => ['required', 'array'],

            'location.latitude' => ['required', 'numeric', 'between:-90,90'],
            'location.longitude' => ['required', 'numeric', 'between:-180,180'],
            'location.altitude' => ['nullable', 'numeric'],
            'location.zip_code' => ['nullable', 'string', 'max:20'],
            'location.city_id' => ['required', 'exists:cities,id'],

            // Many to Many
            'categories' => ['nullable', 'array'],
            'categories.*' => ['exists:categories,id'],

            'features' => ['nullable', 'array'],
            'features.*' => ['exists:features,id'],

            'near_places' => ['nullable', 'array'],
            'near_places.*' => ['exists:near_places,id'],

            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }
}
