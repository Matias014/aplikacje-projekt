<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTournamentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:tournaments,name,' . $this->tournament->id . '|max:40',
            'description' => 'nullable|string|max:255',
            'date' => 'required|date|after_or_equal:today',
            'price' => 'required|numeric|min:0',
            'img' => 'nullable|image|max:500',
            'max_participants' => 'required|integer|min:0',
        ];
    }
}
