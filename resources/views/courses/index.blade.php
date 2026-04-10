@extends('layouts.master')

@section('title', __('messages.all_courses'))

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h2 class="fw-bold">
            <i class="fas fa-graduation-cap"></i> {{ __('messages.all_courses') }}
        </h2>
        <p class="text-muted">{{ __('messages.courses_description') }}</p>
    </div>
    @auth
        @if(auth()->user()->isAdmin())
        <div class="col-md-4 text-end">
            <a href="{{ route('courses.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> {{ __('messages.add_new_course') }}
            </a>
        </div>
        @endif
    @endauth
</div>

<div class="row">
    @forelse($courses as $course)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                @if($course->image)
                    <img src="{{ asset('storage/' . $course->image) }}" class="card-img-top" alt="{{ LaravelLocalization::getCurrentLocale() == 'ar' ? $course->title_ar : $course->title_en }}" style="height: 200px; object-fit: cover;">
                @else
                    <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                        <i class="fas fa-book fa-4x text-white"></i>
                    </div>
                @endif
                
                <div class="card-body">
                    <h5 class="card-title">
                        {{ LaravelLocalization::getCurrentLocale() == 'ar' ? $course->title_ar : $course->title_en }}
                    </h5>
                    <p class="card-text text-muted">
                        {{ Str::limit(LaravelLocalization::getCurrentLocale() == 'ar' ? $course->description_ar : $course->description_en, 100) }}
                    </p>
                    
                    @if($course->level)
                        <span class="badge bg-info mb-2">
                            <i class="fas fa-chart-line"></i> 
                            {{ LaravelLocalization::getCurrentLocale() == 'ar' ? $course->level->name_ar : $course->level->name_en }}
                        </span>
                    @endif
                    
                    <div class="course-price mt-3">
                        @if($course->price > 0)
                            {{ number_format($course->price, 2) }} <small>{{ __('messages.currency') }}</small>
                        @else
                            <span class="text-success">{{ __('messages.free') }}</span>
                        @endif
                    </div>
                </div>
                
                <div class="card-footer bg-transparent border-0 pb-3">
                    <a href="{{ route('courses.show', $course->id) }}" class="btn btn-primary w-100">
                        <i class="fas fa-eye"></i> {{ __('messages.course_details') }}
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle"></i> {{ __('messages.no_courses') }}
            </div>
        </div>
    @endforelse
</div>
@endsection