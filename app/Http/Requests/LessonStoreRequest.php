<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LessonStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'video_url' => 'nullable|url',
            'file_url' => 'nullable|url',
            'order' => 'nullable|integer|min:0',
            'is_free_lesson' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'title_en.required' => 'عنوان الدرس بالإنجليزي مطلوب',
            'title_ar.required' => 'عنوان الدرس بالعربي مطلوب',
            'video_url.url' => 'رابط الفيديو يجب أن يكون رابطاً صحيحاً',
            'file_url.url' => 'رابط الملف يجب أن يكون رابطاً صحيحاً',
            'order.integer' => 'الترتيب يجب أن يكون رقماً',
        ];
    }
}