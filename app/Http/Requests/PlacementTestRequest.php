<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlacementTestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'answers' => 'required|array',
            'answers.*' => 'required|in:a,b,c',
        ];
    }

    public function messages(): array
    {
        return [
            'answers.required' => 'يجب الإجابة على جميع الأسئلة',
            'answers.array' => 'تنسيق الإجابات غير صحيح',
            'answers.*.required' => 'جميع الأسئلة مطلوبة',
            'answers.*.in' => 'الإجابة غير صحيحة',
        ];
    }
}