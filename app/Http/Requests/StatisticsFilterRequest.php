<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StatisticsFilterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $keys = ['year', 'date_from', 'date_to', 'price_min', 'price_max', 'scope', 'include_past'];

        $data = [];
        foreach ($keys as $k) {
            $v = $this->input($k);
            $data[$k] = ($v === '') ? null : $v;
        }

        if ($data['include_past'] !== null) {
            $data['include_past'] = filter_var($data['include_past'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            if ($data['include_past'] === null) {
                $data['include_past'] = false;
            }
        }

        if ($data['scope'] === null) {
            if ($data['include_past'] !== null) {
                $data['scope'] = $data['include_past'] ? 'all' : 'future';
            } else {
                $data['scope'] = 'all';
            }
        }

        $this->merge($data);
    }

    public function rules(): array
    {
        $maxYear = now()->year + 1;

        return [
            'year' => ['nullable', 'integer', 'min:2000', 'max:' . $maxYear],
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],
            'price_min' => ['nullable', 'numeric', 'min:0', 'max:100000'],
            'price_max' => ['nullable', 'numeric', 'min:0', 'max:100000', 'gte:price_min'],
            'scope' => ['nullable', 'in:all,future,past'],
            'include_past' => ['nullable', 'boolean'],
        ];
    }
}
