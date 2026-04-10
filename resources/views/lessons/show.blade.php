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
                @if($lesson->video_url)
                    <div class="mb-4">
                        <h5><i class="fas fa-video"></i> {{ __('messages.video_lesson') }}:</h5>
                        <div class="ratio ratio-16x9">
                            @php
                                // تحويل رابط YouTube إلى رابط embed
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
                
                @if($lesson->file_url)
                    <div class="mb-4">
                        <h5><i class="fas fa-paperclip"></i> {{ __('messages.lesson_files') }}:</h5>
                        <a href="{{ $lesson->file_url }}" class="btn btn-outline-primary" target="_blank">
                            <i class="fas fa-download"></i> {{ __('messages.download_files') }}
                        </a>
                    </div>
                @endif
                
                @if($lesson->is_free_lesson)
                    <div class="alert alert-success">
                        <i class="fas fa-gift"></i> {{ __('messages.free_lesson_message') }}
                    </div>
                @endif
                
                @if(auth()->user() && auth()->user()->isAdmin())
                    <hr>
                    <div class="text-end">
                        <a href="{{ route('courses.lessons.edit', [$course->id, $lesson->id]) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> {{ __('messages.edit_lesson') }}
                        </a>
                    </div>
                @endif

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