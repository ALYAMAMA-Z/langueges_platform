<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DailyWordUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'word_en' => 'sometimes|string|max:255',
            'word_ar' => 'sometimes|string|max:255',
            'definition_en' => 'sometimes|string',
            'definition_ar' => 'sometimes|string',
            'example_en' => 'sometimes|string',
            'example_ar' => 'sometimes|string',
            'scheduled_for' => 'sometimes|date|after_or_equal:today',
        ];
    }
}