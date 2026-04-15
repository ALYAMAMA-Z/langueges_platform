@extends('layouts.master')

@section('title', LaravelLocalization::getCurrentLocale() == 'ar' ? $course->title_ar : $course->title_en)

@section('content')
<div class="row">
    <!-- صورة الكورس والمعلومات الأساسية -->
    <div class="col-md-4 mb-4">
        <div class="card">
            @if($course->image)
                <img src="{{ asset('storage/' . $course->image) }}" class="card-img-top" alt="{{ LaravelLocalization::getCurrentLocale() == 'ar' ? $course->title_ar : $course->title_en }}">
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
                        <span class="display-6 fw-bold text-success">{{ __('messages.free') }}</span>
                    @endif
                </div>
                
                @if($course->level)
                    <div class="text-center mb-3">
                        <span class="badge bg-info fs-6">
                            <i class="fas fa-chart-line"></i> {{ __('messages.level') }}: {{ LaravelLocalization::getCurrentLocale() == 'ar' ? $course->level->name_ar : $course->level->name_en }}
                        </span>
                    </div>
                @endif
                
                @auth
                    @if(auth()->user()->isAdmin())
                        <div class="d-grid gap-2">
                            <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> {{ __('messages.edit') }}
                            </a>
                            <form action="{{ route('courses.destroy', $course->id) }}" method="POST" onsubmit="return confirm(__('messages.are_you_sure'))">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-100">
                                    <i class="fas fa-trash"></i> {{ __('messages.delete') }}
                                </button>
                            </form>
                            <a href="{{ route('courses.lessons.index', $course->id) }}" class="btn btn-info">
                                <i class="fas fa-cog"></i> {{ __('messages.manage_lessons') }}
                            </a>
                        </div>
                    @else
                        @if($isEnrolled ?? false)
                            <div class="d-grid">
                                <a href="{{ route('enrollments.progress', $course->id) }}" class="btn btn-success btn-lg">
                                    <i class="fas fa-play-circle"></i> {{ __('messages.continue_learning') }}
                                </a>
                            </div>
                        @else
                            <div class="d-grid">
                                <a href="{{ route('enrollments.create', $course->id) }}" class="btn btn-primary btn-lg">
                                    <i class="fas fa-shopping-cart"></i> 
                                    @if($course->price > 0)
                                        {{ __('messages.buy_course') }} ({{ number_format($course->price, 2) }} $)
                                    @else
                                        {{ __('messages.free_enrollment') }}
                                    @endif
                                </a>
                            </div>
                        @endif
                    @endif
                @else
                    <div class="d-grid">
                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-sign-in-alt"></i> {{ __('messages.login_to_enroll') }}
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
    
    <!-- تفاصيل الكورس والدروس -->
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-body">
                <h2 class="card-title fw-bold">{{ LaravelLocalization::getCurrentLocale() == 'ar' ? $course->title_ar : $course->title_en }}</h2>
                <hr>
                <h5><i class="fas fa-align-right"></i> {{ __('messages.description') }}:</h5>
                <p class="lead">{{ LaravelLocalization::getCurrentLocale() == 'ar' ? $course->description_ar : $course->description_en }}</p>
            </div>
        </div>
        
        <!-- قائمة الدروس -->
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">
                    <i class="fas fa-list-ol"></i> {{ __('messages.course_content') }}
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
                                        <strong>{{ LaravelLocalization::getCurrentLocale() == 'ar' ? $lesson->title_ar : $lesson->title_en }}</strong>
                                        @if($lesson->is_free_lesson)
                                            <span class="badge bg-success ms-2">
                                                <i class="fas fa-gift"></i> {{ __('messages.free_lesson') }}
                                            </span>
                                        @endif
                                    </div>
                                    <div>
                                        @if($lesson->is_free_lesson || ($isEnrolled ?? false))
                                            <a href="{{ route('courses.lessons.show', [$course->id, $lesson->id]) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-play"></i> {{ __('messages.watch') }}
                                            </a>
                                        @else
                                            <button class="btn btn-sm btn-secondary" disabled>
                                                <i class="fas fa-lock"></i> {{ __('messages.locked') }}
                                            </button>
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

        @if(auth()->user() && auth()->user()->isAdmin())
    <div class="card mt-4">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">
                <i class="fas fa-users"></i> إدارة الطلاب المسجلين
            </h5>
        </div>
        <div class="card-body">
            @if($course->enrollments && $course->enrollments->count() > 0)
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>الطالب</th>
                            <th>البريد</th>
                            <th>الحالة</th>
                            <th>الإجراء</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($course->enrollments as $enrollment)
                        <tr>
                            <td>{{ $enrollment->user->name }}</td>
                            <td>{{ $enrollment->user->email }}</td>
                            <td>
                                @if($enrollment->status == 'active')
                                    <span class="badge bg-success">مفعل</span>
                                @else
                                    <span class="badge bg-warning">قيد الانتظار</span>
                                @endif
                            </td>
                            <td>
                                @if($enrollment->status == 'pending')
                                <form action="{{ route('admin.enrollments.approve', $enrollment->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success btn-sm">
                                        تفعيل
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>لا يوجد طلاب مسجلين</p>
            @endif
        </div>
    </div>
@endif
    </div>
</div>
@endsection