@extends('layouts.master')

@section('title', 'تعديل درس: ' . $lesson->title_ar)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-warning">
                <h4 class="mb-0">
                    <i class="fas fa-edit"></i> تعديل درس: {{ $lesson->title_ar }}
                </h4>
            </div>
            
            <div class="card-body">
                <form action="{{ route('courses.lessons.update', [$course->id, $lesson->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="title_ar" class="form-label">عنوان الدرس (عربي) *</label>
                            <input type="text" name="title_ar" id="title_ar" class="form-control @error('title_ar') is-invalid @enderror" value="{{ old('title_ar', $lesson->title_ar) }}" required>
                            @error('title_ar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="title_en" class="form-label">Lesson Title (English) *</label>
                            <input type="text" name="title_en" id="title_en" class="form-control @error('title_en') is-invalid @enderror" value="{{ old('title_en', $lesson->title_en) }}" required>
                            @error('title_en')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="video_url" class="form-label">رابط الفيديو</label>
                        <input type="url" name="video_url" id="video_url" class="form-control @error('video_url') is-invalid @enderror" value="{{ old('video_url', $lesson->video_url) }}">
                        @if($lesson->video_url)
                            <small class="text-success">الرابط الحالي: {{ Str::limit($lesson->video_url, 50) }}</small>
                        @endif
                        @error('video_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="file_url" class="form-label">رابط الملفات</label>
                        <input type="url" name="file_url" id="file_url" class="form-control @error('file_url') is-invalid @enderror" value="{{ old('file_url', $lesson->file_url) }}">
                        @if($lesson->file_url)
                            <small class="text-success">الرابط الحالي: {{ Str::limit($lesson->file_url, 50) }}</small>
                        @endif
                        @error('file_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="order" class="form-label">ترتيب الدرس</label>
                            <input type="number" name="order" id="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order', $lesson->order) }}" min="0">
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <div class="form-check mt-4">
                                <input type="checkbox" name="is_free_lesson" id="is_free_lesson" class="form-check-input" value="1" {{ old('is_free_lesson', $lesson->is_free_lesson) ? 'checked' : '' }}>
                                <label for="is_free_lesson" class="form-check-label">
                                    <i class="fas fa-gift text-success"></i> درس مجاني
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-end">
                        <a href="{{ route('courses.lessons.index', $course->id) }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> إلغاء
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> تحديث الدرس
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection