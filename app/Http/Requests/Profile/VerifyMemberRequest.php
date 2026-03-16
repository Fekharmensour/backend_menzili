<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class VerifyMemberRequest extends FormRequest
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
            'card_id_front' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:5120'],
            'card_id_back'  => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:5120'],
        ];
    }

}
