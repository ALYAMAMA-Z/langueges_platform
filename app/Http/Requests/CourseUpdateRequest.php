<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CourseUpdateRequest extends FormRequest
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
            'description_en' => 'sometimes|string',
            'description_ar' => 'sometimes|string',
            'price' => 'sometimes|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'level_id' => 'nullable|exists:levels,id',
            'is_live' => 'nullable|boolean',
        ];
    }

      public function messages(): array
    {
        return [
            'price.numeric' => 'السعر يجب أن يكون رقماً',
            'price.min' => 'السعر لا يمكن أن يكون سالباً',
            'level_id.exists' => 'المستوى المختار غير موجود',
        ];
    }
}
