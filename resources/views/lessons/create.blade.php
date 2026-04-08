@extends('layouts.master')

@section('title', 'إضافة درس جديد لكورس: ' . $course->title_ar)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0">
                    <i class="fas fa-plus-circle"></i> إضافة درس جديد
                </h4>
            </div>
            
            <div class="card-body">
                <form action="{{ route('courses.lessons.store', $course->id) }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="title_ar" class="form-label">عنوان الدرس (عربي) *</label>
                            <input type="text" name="title_ar" id="title_ar" class="form-control @error('title_ar') is-invalid @enderror" value="{{ old('title_ar') }}" required>
                            @error('title_ar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="title_en" class="form-label">Lesson Title (English) *</label>
                            <input type="text" name="title_en" id="title_en" class="form-control @error('title_en') is-invalid @enderror" value="{{ old('title_en') }}" required>
                            @error('title_en')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="video_url" class="form-label">رابط الفيديو (YouTube, Vimeo...)</label>
                        <input type="url" name="video_url" id="video_url" class="form-control @error('video_url') is-invalid @enderror" value="{{ old('video_url') }}" placeholder="https://www.youtube.com/watch?v=...">
                        <small class="text-muted">يمكنك وضع رابط من YouTube أو Vimeo أو Google Drive</small>
                        @error('video_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="file_url" class="form-label">رابط الملفات (PDF, DOC...)</label>
                        <input type="url" name="file_url" id="file_url" class="form-control @error('file_url') is-invalid @enderror" value="{{ old('file_url') }}" placeholder="https://example.com/file.pdf">
                        <small class="text-muted">ملفات إضافية مثل PDF أو وثائق الدرس</small>
                        @error('file_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="order" class="form-label">ترتيب الدرس</label>
                            <input type="number" name="order" id="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order', 0) }}" min="0">
                            <small class="text-muted">الرقم الأصغر يظهر أولاً</small>
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <div class="form-check mt-4">
                                <input type="checkbox" name="is_free_lesson" id="is_free_lesson" class="form-check-input" value="1" {{ old('is_free_lesson') ? 'checked' : '' }}>
                                <label for="is_free_lesson" class="form-check-label">
                                    <i class="fas fa-gift text-success"></i> درس مجاني (يمكن مشاهدته قبل الشراء)
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-end">
                        <a href="{{ route('courses.lessons.index', $course->id) }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> إلغاء
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> حفظ الدرس
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection