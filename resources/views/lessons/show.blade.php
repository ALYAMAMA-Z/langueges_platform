@extends('layouts.master')

@section('title', LaravelLocalization::getCurrentLocale() == 'ar' ? $lesson->title_ar : $lesson->title_en)

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="mb-3">
            <a href="{{ route('courses.lessons.index', $course->id) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-right"></i> {{ __('messages.back_to_lessons') }}
            </a>
            <a href="{{ route('courses.show', $course->id) }}" class="btn btn-outline-primary">
                <i class="fas fa-info-circle"></i> {{ __('messages.course_details') }}
            </a>
            
            @if(auth()->user() && auth()->user()->isAdmin())
                <a href="{{ route('courses.lessons.index', $course->id) }}" class="btn btn-primary">
                    <i class="fas fa-cog"></i> {{ __('messages.manage_lessons') }}
                </a>
            @endif
        </div>
        
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">{{ LaravelLocalization::getCurrentLocale() == 'ar' ? $lesson->title_ar : $lesson->title_en }}</h3>
                @if($lesson->title_en && LaravelLocalization::getCurrentLocale() == 'ar')
                    <h6 class="mb-0 text-light">{{ $lesson->title_en }}</h6>
                @endif
                @if($lesson->title_ar && LaravelLocalization::getCurrentLocale() == 'en')
                    <h6 class="mb-0 text-light">{{ $lesson->title_ar }}</h6>
                @endif
            </div>
            
            <div class="card-body">
                <!-- قسم الدرس المباشر (يظهر أولاً) -->
             @if($lesson->is_live)
    <div class="card mb-4">
        <div class="card-header bg-danger text-white">
            <h5 class="mb-0">
                <i class="fas fa-broadcast-tower"></i> {{ __('messages.live_lesson') }}
            </h5>
        </div>
        <div class="card-body text-center">
            @php
                $status = $lesson->getLiveStatusAttribute();
            @endphp
            
            @if($status == 'live_now')
                <div class="alert alert-danger">
                    <i class="fas fa-circle text-danger me-2" style="font-size: 12px; animation: pulse 1s infinite;"></i>
                    <strong>{{ __('messages.live_now') }}</strong>
                </div>
                <a href="{{ $lesson->live_join_url }}" class="btn btn-danger btn-lg" target="_blank">
                    <i class="fas fa-video"></i> {{ __('messages.join_live_lesson') }}
                </a>
            @elseif($status == 'upcoming')
                <div class="alert alert-info">
                    <i class="fas fa-calendar-alt me-2"></i>
                    <strong>{{ __('messages.live_upcoming') }}</strong>
                    @if($lesson->live_start_time)
                        <br>{{ __('messages.live_start_at') }}: {{ $lesson->live_start_time->format('Y-m-d H:i') }}
                    @endif
                </div>
                <button class="btn btn-secondary btn-lg" disabled>
                    <i class="fas fa-clock"></i> {{ __('messages.waiting_for_start') }}
                </button>
            @else
                <div class="alert alert-secondary">
                    <i class="fas fa-archive me-2"></i>
                    {{ __('messages.live_ended') }}
                </div>
            @endif
            
            <div class="mt-3">
                <small class="text-muted">
                    {{ __('messages.live_platform_label') }}: {{ ucfirst($lesson->live_platform) }}
                </small>
            </div>
        </div>
    </div>
    
    <style>
        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.3; }
            100% { opacity: 1; }
        }
    </style>
@endif
                
                <!-- الفيديو المسجل -->
                @if($lesson->video_url)
                    <div class="mb-4">
                        <h5><i class="fas fa-video"></i> {{ __('messages.video_lesson') }}:</h5>
                        <div class="ratio ratio-16x9">
                            @php
                                $videoUrl = $lesson->video_url;
                                if (strpos($videoUrl, 'youtube.com/watch?v=') !== false) {
                                    $videoId = substr($videoUrl, strpos($videoUrl, 'v=') + 2);
                                    $videoUrl = 'https://www.youtube.com/embed/' . $videoId;
                                } elseif (strpos($videoUrl, 'youtu.be/') !== false) {
                                    $videoId = substr($videoUrl, strpos($videoUrl, 'be/') + 3);
                                    $videoUrl = 'https://www.youtube.com/embed/' . $videoId;
                                } elseif (strpos($videoUrl, 'vimeo.com') !== false) {
                                    $videoId = substr($videoUrl, strrpos($videoUrl, '/') + 1);
                                    $videoUrl = 'https://player.vimeo.com/video/' . $videoId;
                                }
                            @endphp
                            <iframe src="{{ $videoUrl }}" class="embed-responsive-item" allowfullscreen></iframe>
                        </div>
                    </div>
                @endif
                
                <!-- ملفات الدرس -->
                @if($lesson->file_url)
                    <div class="mb-4">
                        <h5><i class="fas fa-paperclip"></i> {{ __('messages.lesson_files') }}:</h5>
                        <a href="{{ $lesson->file_url }}" class="btn btn-outline-primary" target="_blank">
                            <i class="fas fa-download"></i> {{ __('messages.download_files') }}
                        </a>
                    </div>
                @endif
                
                <!-- رسالة الدرس المجاني -->
                @if($lesson->is_free_lesson)
                    <div class="alert alert-success">
                        <i class="fas fa-gift"></i> {{ __('messages.free_lesson_message') }}
                    </div>
                @endif
                
                <!-- أزرار الأدمن -->
                @if(auth()->user() && auth()->user()->isAdmin())
                    <hr>
                    <div class="text-end">
                        <a href="{{ route('courses.lessons.edit', [$course->id, $lesson->id]) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> {{ __('messages.edit_lesson') }}
                        </a>
                    </div>
                @endif

                <!-- زر إكمال الدرس للطلاب -->
                @if(auth()->user() && !auth()->user()->isAdmin() && !$lesson->is_free_lesson)
                    <hr>
                    <div class="text-center">
                        <form action="{{ route('enrollments.complete-lesson', $lesson->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-check-circle"></i> {{ __('messages.mark_completed') }}
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection