@extends('layouts.master')

@section('title', __('messages.edit_lesson') . ': ' . (LaravelLocalization::getCurrentLocale() == 'ar' ? $lesson->title_ar : $lesson->title_en))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-warning">
                <h4 class="mb-0">
                    <i class="fas fa-edit"></i> {{ __('messages.edit_lesson') }}: {{ LaravelLocalization::getCurrentLocale() == 'ar' ? $lesson->title_ar : $lesson->title_en }}
                </h4>
            </div>
            
            <div class="card-body">
                <form action="{{ route('courses.lessons.update', [$course->id, $lesson->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="title_ar" class="form-label">{{ __('messages.lesson_title_ar') }} *</label>
                            <input type="text" name="title_ar" id="title_ar" class="form-control @error('title_ar') is-invalid @enderror" value="{{ old('title_ar', $lesson->title_ar) }}" required>
                            @error('title_ar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="title_en" class="form-label">{{ __('messages.lesson_title_en') }} *</label>
                            <input type="text" name="title_en" id="title_en" class="form-control @error('title_en') is-invalid @enderror" value="{{ old('title_en', $lesson->title_en) }}" required>
                            @error('title_en')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="video_url" class="form-label">{{ __('messages.video_url') }}</label>
                        <input type="url" name="video_url" id="video_url" class="form-control @error('video_url') is-invalid @enderror" value="{{ old('video_url', $lesson->video_url) }}">
                        @if($lesson->video_url)
                            <small class="text-success">{{ __('messages.current_url') }}: {{ Str::limit($lesson->video_url, 50) }}</small>
                        @endif
                        @error('video_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="file_url" class="form-label">{{ __('messages.file_url') }}</label>
                        <input type="url" name="file_url" id="file_url" class="form-control @error('file_url') is-invalid @enderror" value="{{ old('file_url', $lesson->file_url) }}">
                        @if($lesson->file_url)
                            <small class="text-success">{{ __('messages.current_url') }}: {{ Str::limit($lesson->file_url, 50) }}</small>
                        @endif
                        @error('file_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="order" class="form-label">{{ __('messages.lesson_order') }}</label>
                            <input type="number" name="order" id="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order', $lesson->order) }}" min="0">
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <div class="form-check mt-4">
                                <input type="checkbox" name="is_free_lesson" id="is_free_lesson" class="form-check-input" value="1" {{ old('is_free_lesson', $lesson->is_free_lesson) ? 'checked' : '' }}>
                                <label for="is_free_lesson" class="form-check-label">
                                    <i class="fas fa-gift text-success"></i> {{ __('messages.free_lesson_checkbox') }}
                                </label>
                            </div>
                        </div>
                    </div>
                    <!-- قسم الدرس المباشر -->
<div class="card mb-3">
    <div class="card-header bg-info text-white">
        <h5 class="mb-0">
            <i class="fas fa-video"></i> {{ __('messages.live_lesson_settings') }}
        </h5>
    </div>
    <div class="card-body">
        <div class="form-check mb-3">
            <input type="checkbox" name="is_live" id="is_live" class="form-check-input" value="1" {{ old('is_live', $lesson->is_live) ? 'checked' : '' }}>
            <label for="is_live" class="form-check-label">
                <i class="fas fa-broadcast-tower"></i> {{ __('messages.is_live_lesson') }}
            </label>
        </div>
        
        <div class="live-fields" style="display: {{ old('is_live', $lesson->is_live) ? 'block' : 'none' }};">
            <div class="mb-3">
                <label for="live_platform" class="form-label">{{ __('messages.live_platform') }}</label>
                <select name="live_platform" id="live_platform" class="form-control">
                    <option value="zoom" {{ old('live_platform', $lesson->live_platform) == 'zoom' ? 'selected' : '' }}>Zoom</option>
                    <option value="google_meet" {{ old('live_platform', $lesson->live_platform) == 'google_meet' ? 'selected' : '' }}>Google Meet</option>
                    <option value="youtube_live" {{ old('live_platform', $lesson->live_platform) == 'youtube_live' ? 'selected' : '' }}>YouTube Live</option>
                    <option value="other" {{ old('live_platform', $lesson->live_platform) == 'other' ? 'selected' : '' }}>أخرى</option>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="live_join_url" class="form-label">{{ __('messages.live_join_url') }}</label>
                <input type="url" name="live_join_url" id="live_join_url" class="form-control" 
                       value="{{ old('live_join_url', $lesson->live_join_url) }}" 
                       placeholder="https://zoom.us/j/...">
                <small class="text-muted">{{ __('messages.live_join_url_help') }}</small>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="live_start_time" class="form-label">{{ __('messages.live_start_time') }}</label>
                    <input type="datetime-local" name="live_start_time" id="live_start_time" class="form-control" 
                           value="{{ old('live_start_time', $lesson->live_start_time ? $lesson->live_start_time->format('Y-m-d\TH:i') : '') }}">
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="live_duration" class="form-label">{{ __('messages.live_duration') }}</label>
                    <input type="number" name="live_duration" id="live_duration" class="form-control" 
                           value="{{ old('live_duration', $lesson->live_duration ?? 60) }}" 
                           placeholder="دقيقة">
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('is_live').addEventListener('change', function() {
        const liveFields = document.querySelector('.live-fields');
        liveFields.style.display = this.checked ? 'block' : 'none';
    });
</script>
                    
                    <div class="text-end">
                        <a href="{{ route('courses.lessons.index', $course->id) }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> {{ __('messages.cancel') }}
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> {{ __('messages.update_lesson') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection