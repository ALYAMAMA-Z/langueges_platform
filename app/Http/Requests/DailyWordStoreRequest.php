<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DailyWordStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'word_en' => 'required|string|max:255',
            'word_ar' => 'required|string|max:255',
            'definition_en' => 'required|string',
            'definition_ar' => 'required|string',
            'example_en' => 'required|string',
            'example_ar' => 'required|string',
            'scheduled_for' => 'required|date|after_or_equal:today',
        ];
    }

    public function messages(): array
    {
        return [
            'word_en.required' => 'الكلمة بالإنجليزية مطلوبة',
            'word_ar.required' => 'الكلمة بالعربية مطلوبة',
            'definition_en.required' => 'التعريف بالإنجليزية مطلوب',
            'definition_ar.required' => 'التعريف بالعربية مطلوب',
            'example_en.required' => 'المثال بالإنجليزية مطلوب',
            'example_ar.required' => 'المثال بالعربية مطلوب',
            'scheduled_for.required' => 'تاريخ الإرسال مطلوب',
            'scheduled_for.after_or_equal' => 'تاريخ الإرسال يجب أن يكون اليوم أو مستقبلاً',
        ];
    }
}