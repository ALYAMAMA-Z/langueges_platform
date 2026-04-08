<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CourseStoreRequest extends FormRequest
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
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'level_id' => 'nullable|exists:levels,id',
            'is_live' => 'nullable|boolean',
        ];
    }

       public function messages(): array
    {
        return [
            'title_en.required' => 'عنوان الكورس بالإنجليزي مطلوب',
            'title_ar.required' => 'عنوان الكورس بالعربي مطلوب',
            'description_en.required' => 'وصف الكورس بالإنجليزي مطلوب',
            'description_ar.required' => 'وصف الكورس بالعربي مطلوب',
            'price.required' => 'سعر الكورس مطلوب',
            'price.numeric' => 'السعر يجب أن يكون رقماً',
            'price.min' => 'السعر لا يمكن أن يكون سالباً',
            'image.image' => 'الملف يجب أن يكون صورة',
            'image.mimes' => 'الصورة يجب أن تكون من نوع jpeg, png, jpg',
            'level_id.exists' => 'المستوى المختار غير موجود',
        ];
    }
}
