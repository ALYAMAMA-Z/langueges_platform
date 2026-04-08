@extends('layouts.master')

@section('title', $course->title_ar)

@section('content')
<div class="row">
    <!-- صورة الكورس والمعلومات الأساسية -->
    <div class="col-md-4 mb-4">
        <div class="card">
            @if($course->image)
                <img src="{{ asset('storage/' . $course->image) }}" class="card-img-top" alt="{{ $course->title_ar }}">
            @else
                <div class="bg-secondary d-flex align-items-center justify-content-center" style="height: 300px;">
                    <i class="fas fa-book fa-5x text-white"></i>
                </div>
            @endif
            
            <div class="card-body">
                <div class="course-price text-center mb-3">
                    @if($course->price > 0)
                        <span class="display-6 fw-bold text-primary">{{ number_format($course->price, 2) }} $</span>
                    @else
                        <span class="display-6 fw-bold text-success">مجاني</span>
                    @endif
                </div>
                
                @if($course->level)
                    <div class="text-center mb-3">
                        <span class="badge bg-info fs-6">
                            <i class="fas fa-chart-line"></i> المستوى: {{ $course->level->name_ar }}
                        </span>
                    </div>
                @endif
                
               @auth
    @if(auth()->user()->isAdmin())
        <div class="d-grid gap-2">
            <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> تعديل الكورس
            </a>
            <form action="{{ route('courses.destroy', $course->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا الكورس؟')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger w-100">
                    <i class="fas fa-trash"></i> حذف الكورس
                </button>
            </form>
            <!-- ✅ زر إدارة الدروس الجديد -->
            <a href="{{ route('courses.lessons.index', $course->id) }}" class="btn btn-info">
                <i class="fas fa-cog"></i> إدارة الدروس
            </a>
        </div>
    @else
         <div class="d-grid">
        <a href="{{ route('enrollments.create', $course->id) }}" class="btn btn-primary btn-lg">
            <i class="fas fa-shopping-cart"></i> 
            @if($course->price > 0)
                شراء الكورس ({{ number_format($course->price, 2) }} $)
            @else
                تسجيل مجاني
            @endif
        </a>
    </div>
    @endif
@endauth
            </div>
        </div>
    </div>
    
    <!-- تفاصيل الكورس والدروس -->
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-body">
                <h2 class="card-title fw-bold">{{ $course->title_ar }}</h2>
                <h5 class="text-muted">{{ $course->title_en }}</h5>
                <hr>
                <h5><i class="fas fa-align-right"></i> وصف الكورس:</h5>
                <p class="lead">{{ $course->description_ar }}</p>
                
                @if($course->description_en)
                    <hr>
                    <h5><i class="fas fa-align-left"></i> Course Description:</h5>
                    <p class="text-muted">{{ $course->description_en }}</p>
                @endif
            </div>
        </div>
        
        <!-- قائمة الدروس -->
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">
                    <i class="fas fa-list-ol"></i> محتوى الكورس
                </h4>
            </div>
            <div class="card-body">
                @if($course->lessons && $course->lessons->count() > 0)
                    <div class="list-group">
                        @foreach($course->lessons as $index => $lesson)
                            <div class="list-group-item list-group-item-action">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="badge bg-secondary rounded-pill me-2">{{ $index + 1 }}</span>
                                        <strong>{{ $lesson->title_ar }}</strong>
                                        @if($lesson->is_free_lesson)
                                            <span class="badge bg-success ms-2">
                                                <i class="fas fa-gift"></i> درس مجاني
                                            </span>
                                        @endif
                                    </div>
                                    <div>
                                        @if($lesson->is_free_lesson)
                                            <a href="#" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-play"></i> مشاهدة
                                            </a>
                                        @else
                                            <button class="btn btn-sm btn-secondary" disabled>
                                                <i class="fas fa-lock"></i> قيد الشراء
                                            </button>
                                        @endif
                                    </div>
                                </div>
                                
                                @if($lesson->description_ar)
                                    <div class="mt-2 text-muted small">
                                        {{ Str::limit($lesson->description_ar, 100) }}
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info text-center">
                        <i class="fas fa-info-circle"></i> لا توجد دروس مضافة لهذا الكورس بعد
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection