@extends('layouts.master')

@section('title', $lesson->title_ar)

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="mb-3">
            <a href="{{ route('courses.lessons.index', $course->id) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-right"></i> العودة للدروس
            </a>
            <a href="{{ route('courses.show', $course->id) }}" class="btn btn-outline-primary">
                <i class="fas fa-info-circle"></i> تفاصيل الكورس
            </a>
            
            @if(auth()->user() && auth()->user()->isAdmin())
                <a href="{{ route('courses.lessons.index', $course->id) }}" class="btn btn-primary">
                    <i class="fas fa-cog"></i> إدارة الدروس
                </a>
            @endif
        </div>
        
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">{{ $lesson->title_ar }}</h3>
                @if($lesson->title_en)
                    <h6 class="mb-0 text-light">{{ $lesson->title_en }}</h6>
                @endif
            </div>
            
            <div class="card-body">
                @if($lesson->video_url)
                    <div class="mb-4">
                        <h5><i class="fas fa-video"></i> فيديو الدرس:</h5>
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
                        <h5><i class="fas fa-paperclip"></i> ملفات الدرس:</h5>
                        <a href="{{ $lesson->file_url }}" class="btn btn-outline-primary" target="_blank">
                            <i class="fas fa-download"></i> تحميل الملفات
                        </a>
                    </div>
                @endif
                
                @if($lesson->is_free_lesson)
                    <div class="alert alert-success">
                        <i class="fas fa-gift"></i> هذا الدرس مجاني للجميع
                    </div>
                @endif
                
                @if(auth()->user() && auth()->user()->isAdmin())
                    <hr>
                    <div class="text-end">
                        <a href="{{ route('courses.lessons.edit', [$course->id, $lesson->id]) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> تعديل الدرس
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection