<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StatisticsImageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'image' => $this->input('image') === '' ? null : $this->input('image'),
            'name' => $this->input('name') === '' ? null : $this->input('name'),
            'format' => $this->input('format') === '' ? null : $this->input('format'),
        ]);
    }

    public function rules(): array
    {
        return [
            'image' => ['required', 'string', 'max:7000000'],
            'format' => ['required', 'in:png,jpg'],
            'name' => ['required', 'string', 'max:50', 'regex:/^[a-zA-Z0-9 _-]+$/'],
        ];
    }
}
