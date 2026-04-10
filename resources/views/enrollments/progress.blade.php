@extends('layouts.master')

@section('title', __('messages.my_progress') . ' - ' . (LaravelLocalization::getCurrentLocale() == 'ar' ? $course->title_ar : $course->title_en))

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h2 class="fw-bold">
            <i class="fas fa-chart-line"></i> {{ __('messages.my_progress') }}: {{ LaravelLocalization::getCurrentLocale() == 'ar' ? $course->title_ar : $course->title_en }}
        </h2>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('enrollments.my-courses') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-right"></i> {{ __('messages.my_courses') }}
        </a>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <h5>{{ __('messages.progress') }}</h5>
        <div class="progress mb-2" style="height: 30px;">
            <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" style="width: {{ $progressPercentage }}%">
                {{ round($progressPercentage) }}%
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">
            <i class="fas fa-list-ol"></i> {{ __('messages.course_content') }}
        </h4>
    </div>
    <div class="card-body">
        @if($lessons->count() > 0)
            <div class="list-group">
                @foreach($lessons as $index => $lesson)
                    <div class="list-group-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge bg-secondary rounded-pill me-2">{{ $index + 1 }}</span>
                                <strong>{{ LaravelLocalization::getCurrentLocale() == 'ar' ? $lesson->title_ar : $lesson->title_en }}</strong>
                                @if(in_array($lesson->id, $completedLessonsIds))
                                    <span class="badge bg-success ms-2">
                                        <i class="fas fa-check-circle"></i> {{ __('messages.completed') }}
                                    </span>
                                @endif
                            </div>
                            <div>
                                <a href="{{ route('courses.lessons.show', [$course->id, $lesson->id]) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-play"></i> {{ __('messages.watch') }}
                                </a>
                                
                                @if(!in_array($lesson->id, $completedLessonsIds))
                                    <form action="{{ route('enrollments.complete-lesson', $lesson->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">
                                            <i class="fas fa-check"></i> {{ __('messages.complete') }}
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle"></i> {{ __('messages.no_lessons') }}
            </div>
        @endif
    </div>
</div>

@if($progressPercentage >= 100)
    <div class="alert alert-success mt-3">
        <i class="fas fa-trophy"></i> {{ __('messages.congratulations_completion') }}
    </div>
    
    <form action="{{ route('certificates.generate', $course->id) }}" method="POST" class="mt-2">
        @csrf
        <button type="submit" class="btn btn-success btn-lg w-100">
            <i class="fas fa-certificate"></i> {{ __('messages.get_my_certificate') }} 🎉
        </button>
    </form>
@endif
@endsection