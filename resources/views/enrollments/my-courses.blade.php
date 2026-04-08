@extends('layouts.master')

@section('title', 'كورساتي')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h2 class="fw-bold">
            <i class="fas fa-graduation-cap"></i> كورساتي
        </h2>
        <p class="text-muted">الكورسات التي اشتركت فيها</p>
    </div>
</div>

@if($enrollments->count() > 0)
    <div class="row">
        @foreach($enrollments as $enrollment)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    @if($enrollment->course->image)
                        <img src="{{ asset('storage/' . $enrollment->course->image) }}" class="card-img-top" alt="{{ $enrollment->course->title_ar }}" style="height: 200px; object-fit: cover;">
                    @else
                        <div class="bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                            <i class="fas fa-book fa-4x text-white"></i>
                        </div>
                    @endif
                    
                    <div class="card-body">
                        <h5 class="card-title">{{ $enrollment->course->title_ar }}</h5>
                        <p class="card-text text-muted">{{ Str::limit($enrollment->course->description_ar, 100) }}</p>
                        
                        <div class="progress mb-2" style="height: 10px;">
                            <div class="progress-bar bg-success" style="width: {{ $enrollment->completionPercentage() }}%"></div>
                        </div>
                        <small class="text-muted">تقدم: {{ round($enrollment->completionPercentage()) }}%</small>
                    </div>
                    
                    <div class="card-footer bg-transparent border-0 pb-3">
                        <a href="{{ route('enrollments.progress', $enrollment->course->id) }}" class="btn btn-primary w-100">
                            <i class="fas fa-play-circle"></i> متابعة التعلم
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="alert alert-info text-center">
        <i class="fas fa-info-circle"></i> لم تشترك في أي كورس بعد
    </div>
@endif
@endsection