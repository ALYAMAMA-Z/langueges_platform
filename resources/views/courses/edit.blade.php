@extends('layouts.master')

@section('title', 'تعديل كورس: ' . $course->title_ar)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-warning">
                <h4 class="mb-0">
                    <i class="fas fa-edit"></i> تعديل الكورس: {{ $course->title_ar }}
                </h4>
            </div>
            
            <div class="card-body">
                <form action="{{ route('courses.update', $course->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="title_ar" class="form-label">عنوان الكورس (عربي) *</label>
                            <input type="text" name="title_ar" id="title_ar" class="form-control @error('title_ar') is-invalid @enderror" value="{{ old('title_ar', $course->title_ar) }}" required>
                            @error('title_ar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="title_en" class="form-label">Course Title (English) *</label>
                            <input type="text" name="title_en" id="title_en" class="form-control @error('title_en') is-invalid @enderror" value="{{ old('title_en', $course->title_en) }}" required>
                            @error('title_en')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="description_ar" class="form-label">وصف الكورس (عربي) *</label>
                            <textarea name="description_ar" id="description_ar" rows="4" class="form-control @error('description_ar') is-invalid @enderror" required>{{ old('description_ar', $course->description_ar) }}</textarea>
                            @error('description_ar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="description_en" class="form-label">Course Description (English) *</label>
                            <textarea name="description_en" id="description_en" rows="4" class="form-control @error('description_en') is-invalid @enderror" required>{{ old('description_en', $course->description_en) }}</textarea>
                            @error('description_en')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="price" class="form-label">السعر (دولار) *</label>
                            <input type="number" step="0.01" name="price" id="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $course->price) }}" required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="level_id" class="form-label">المستوى</label>
                            <select name="level_id" id="level_id" class="form-control @error('level_id') is-invalid @enderror">
                                <option value="">اختر المستوى</option>
                                @foreach($levels as $level)
                                    <option value="{{ $level->id }}" {{ old('level_id', $course->level_id) == $level->id ? 'selected' : '' }}>
                                        {{ $level->name_ar }}
                                    </option>
                                @endforeach
                            </select>
                            @error('level_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="image" class="form-label">صورة الغلاف</label>
                            @if($course->image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $course->image) }}" class="img-thumbnail" style="max-height: 100px;">
                                </div>
                            @endif
                            <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                            <small class="text-muted">اتركه فارغًا إذا لم ترد تغيير الصورة</small>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="is_live" id="is_live" class="form-check-input" value="1" {{ old('is_live', $course->is_live) ? 'checked' : '' }}>
                            <label for="is_live" class="form-check-label">
                                كورس مباشر (Live)
                            </label>
                        </div>
                    </div>
                    
                    <div class="text-end">
                        <a href="{{ route('courses.show', $course->id) }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> إلغاء
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> تحديث الكورس
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection