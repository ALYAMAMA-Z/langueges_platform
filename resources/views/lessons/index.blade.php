@extends('layouts.master')

@section('title', 'دروس كورس: ' . $course->title_ar)

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h2 class="fw-bold">
            <i class="fas fa-book"></i> دروس كورس: {{ $course->title_ar }}
        </h2>
        <a href="{{ route('courses.show', $course->id) }}" class="btn btn-secondary mt-2">
            <i class="fas fa-arrow-right"></i> العودة للكورس
        </a>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('courses.lessons.create', $course->id) }}" class="btn btn-success">
            <i class="fas fa-plus"></i> إضافة درس جديد
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">
            <i class="fas fa-list-ol"></i> قائمة الدروس
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
                                @if($lesson->is_free_lesson)
                                    <span class="badge bg-success ms-2">
                                        <i class="fas fa-gift"></i> مجاني
                                    </span>
                                @endif
                            </div>
                            <div>
                                <a href="{{ route('courses.lessons.show', [$course->id, $lesson->id]) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('courses.lessons.edit', [$course->id, $lesson->id]) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('courses.lessons.destroy', [$course->id, $lesson->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا الدرس؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        @if($lesson->video_url || $lesson->file_url)
                            <div class="mt-2">
                                @if($lesson->video_url)
                                    <span class="badge bg-info">
                                        <i class="fas fa-video"></i> فيديو
                                    </span>
                                @endif
                                @if($lesson->file_url)
                                    <span class="badge bg-secondary">
                                        <i class="fas fa-file"></i> ملفات
                                    </span>
                                @endif
                            </div>
                        @endif
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