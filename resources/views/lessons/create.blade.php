@extends('layouts.master')

@section('title', __('messages.add_new_lesson') . ' - ' . (LaravelLocalization::getCurrentLocale() == 'ar' ? $course->title_ar : $course->title_en))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0">
                    <i class="fas fa-plus-circle"></i> {{ __('messages.add_new_lesson') }}
                </h4>
            </div>
            
            <div class="card-body">
                <form action="{{ route('courses.lessons.store', $course->id) }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="title_ar" class="form-label">{{ __('messages.lesson_title_ar') }} *</label>
                            <input type="text" name="title_ar" id="title_ar" class="form-control @error('title_ar') is-invalid @enderror" value="{{ old('title_ar') }}" required>
                            @error('title_ar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="title_en" class="form-label">{{ __('messages.lesson_title_en') }} *</label>
                            <input type="text" name="title_en" id="title_en" class="form-control @error('title_en') is-invalid @enderror" value="{{ old('title_en') }}" required>
                            @error('title_en')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="video_url" class="form-label">{{ __('messages.video_url') }}</label>
                        <input type="url" name="video_url" id="video_url" class="form-control @error('video_url') is-invalid @enderror" value="{{ old('video_url') }}" placeholder="https://www.youtube.com/watch?v=...">
                        <small class="text-muted">{{ __('messages.video_url_help') }}</small>
                        @error('video_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="file_url" class="form-label">{{ __('messages.file_url') }}</label>
                        <input type="url" name="file_url" id="file_url" class="form-control @error('file_url') is-invalid @enderror" value="{{ old('file_url') }}" placeholder="https://example.com/file.pdf">
                        <small class="text-muted">{{ __('messages.file_url_help') }}</small>
                        @error('file_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="order" class="form-label">{{ __('messages.lesson_order') }}</label>
                            <input type="number" name="order" id="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order', 0) }}" min="0">
                            <small class="text-muted">{{ __('messages.lesson_order_help') }}</small>
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <div class="form-check mt-4">
                                <input type="checkbox" name="is_free_lesson" id="is_free_lesson" class="form-check-input" value="1" {{ old('is_free_lesson') ? 'checked' : '' }}>
                                <label for="is_free_lesson" class="form-check-label">
                                    <i class="fas fa-gift text-success"></i> {{ __('messages.free_lesson_checkbox') }}
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-end">
                        <a href="{{ route('courses.lessons.index', $course->id) }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> {{ __('messages.cancel') }}
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> {{ __('messages.save_lesson') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection