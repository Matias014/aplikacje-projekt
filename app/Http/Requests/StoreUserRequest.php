<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'username' => 'required|string|max:20|unique:users,username',
            'name' => 'required|string|max:20',
            'surname' => 'required|string|max:25',
            'email' => 'required|string|email|max:60|unique:users,email',
            'password' => 'required|string|max:100',
            'avatar' => 'nullable|image|max:500',
        ];
    }
}