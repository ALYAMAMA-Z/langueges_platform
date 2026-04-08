@extends('layouts.master')

@section('title', 'تقدمي في كورس: ' . $course->title_ar)

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h2 class="fw-bold">
            <i class="fas fa-chart-line"></i> تقدمي في: {{ $course->title_ar }}
        </h2>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('enrollments.my-courses') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-right"></i> كورساتي
        </a>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <h5>نسبة التقدم</h5>
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
            <i class="fas fa-list-ol"></i> محتوى الكورس
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
                                <strong>{{ $lesson->title_ar }}</strong>
                                @if(in_array($lesson->id, $completedLessonsIds))
                                    <span class="badge bg-success ms-2">
                                        <i class="fas fa-check-circle"></i> مكتمل
                                    </span>
                                @endif
                            </div>
                            <div>
                                <a href="{{ route('courses.lessons.show', [$course->id, $lesson->id]) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-play"></i> مشاهدة
                                </a>
                                
                                @if(!in_array($lesson->id, $completedLessonsIds))
                                    <form action="{{ route('enrollments.complete-lesson', $lesson->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">
                                            <i class="fas fa-check"></i> تأكيد الإكمال
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
                <i class="fas fa-info-circle"></i> لا توجد دروس في هذا الكورس بعد
            </div>
        @endif
    </div>
</div>
@endsection