<?php

namespace App\Http\Requests\Api\Listing;

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

            'title' => ['sometimes','string','max:255'],
            'description' => ['nullable','string'],

            'price' => ['sometimes','numeric','min:0'],
            'floor' => ['nullable','integer','min:0'],
            'surface' => ['sometimes','numeric','min:0'],

            'boost_level'=> ['nullable','integer','min:1','max:10'],

            'min_duration' => ['nullable','integer','min:1'],
            'number_rooms' => ['nullable','integer','min:1'],
            'number_persons' => ['nullable','integer','min:1'],

            'is_ready' => ['sometimes','boolean'],
            'is_active' => ['sometimes','boolean'],
            'is_negotiable' => ['sometimes','boolean'],

            'main_image' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:10240'],

            'location' => ['sometimes','array'],
            'location.latitude' => ['required_with:location','numeric'],
            'location.longitude' => ['required_with:location','numeric'],
            'location.city_id' => ['required_with:location','exists:cities,id'],

            'categories' => ['nullable','array'],
            'categories.*' => ['exists:categories,id'],

            'features' => ['nullable','array'],
            'features.*' => ['exists:features,id'],

            'near_places' => ['nullable','array'],
            'near_places.*' => ['exists:near_places,id'],

            'images' => ['nullable','array','max:5'],
            'images.*' => ['image','mimes:jpg,jpeg,png,webp','max:10240'],
        ];
    }
}
