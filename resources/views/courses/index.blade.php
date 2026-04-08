@extends('layouts.master')

@section('title', 'جميع الكورسات')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h2 class="fw-bold">
            <i class="fas fa-graduation-cap"></i> كورسات تعلم اللغات
        </h2>
        <p class="text-muted">اختر الكورس المناسب لمستواك وابدأ رحلة التعلم</p>
    </div>
    @auth
        @if(auth()->user()->isAdmin())
        <div class="col-md-4 text-end">
            <a href="{{ route('courses.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> إضافة كورس جديد
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
                    <img src="{{ asset('storage/' . $course->image) }}" class="card-img-top" alt="{{ $course->title_ar }}" style="height: 200px; object-fit: cover;">
                @else
                    <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                        <i class="fas fa-book fa-4x text-white"></i>
                    </div>
                @endif
                
                <div class="card-body">
                    <h5 class="card-title">{{ $course->title_ar }}</h5>
                    <p class="card-text text-muted">{{ Str::limit($course->description_ar, 100) }}</p>
                    
                    @if($course->level)
                        <span class="badge bg-info mb-2">
                            <i class="fas fa-chart-line"></i> {{ $course->level->name_ar }}
                        </span>
                    @endif
                    
                    <div class="course-price mt-3">
                        @if($course->price > 0)
                            {{ number_format($course->price, 2) }} <small>دولار</small>
                        @else
                            <span class="text-success">مجاني</span>
                        @endif
                    </div>
                </div>
                
                <div class="card-footer bg-transparent border-0 pb-3">
                    <a href="{{ route('courses.show', $course->id) }}" class="btn btn-primary w-100">
                        <i class="fas fa-eye"></i> تفاصيل الكورس
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle"></i> لا توجد كورسات حالياً
            </div>
        </div>
    @endforelse
</div>
@endsection