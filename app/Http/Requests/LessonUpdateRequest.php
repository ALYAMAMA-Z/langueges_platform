<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LessonUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'title_en' => 'sometimes|string|max:255',
        'title_ar' => 'sometimes|string|max:255',
        'video_url' => 'nullable|url',
        'file_url' => 'nullable|url',
        'order' => 'nullable|integer|min:0',
        'is_free_lesson' => 'nullable|boolean',
        'is_live' => 'nullable|boolean',
        'live_platform' => 'nullable|string|in:zoom,google_meet,youtube_live,other',
        'live_join_url' => 'nullable|url',
        'live_start_time' => 'nullable|date',
        'live_duration' => 'nullable|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'video_url.url' => 'رابط الفيديو يجب أن يكون رابطاً صحيحاً',
            'file_url.url' => 'رابط الملف يجب أن يكون رابطاً صحيحاً',
        ];
    }
}