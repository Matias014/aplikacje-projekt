<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTournamentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:tournaments,name|max:40',
            'description' => 'nullable|string|max:255',
            'date' => 'required|date|after_or_equal:today',
            'price' => 'required|numeric|min:0',
            'img' => 'required|image|max:500',
            'max_participants' => 'required|integer|min:0',
        ];
    }
}
