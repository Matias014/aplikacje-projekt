<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTournamentRequest extends FormRequest
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
            'name' => 'required|string|unique:tournaments,name|max:40',
            'description' => 'nullable|string|max:255',
            'date' => 'required|date',
            'price' => 'required|numeric|min:0',
            'img' => 'nullable|string|max:255',
            'max_team_alfa' => 'required|integer|min:0',
            'max_team_beta' => 'required|integer|min:0',
            'max_team_gamma' => 'required|integer|min:0',
            'max_team_delta' => 'required|integer|min:0',
        ];
    }
}
