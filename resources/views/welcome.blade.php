@extends('layouts.master')

@section('title', 'الصفحة الرئيسية')

@section('content')
<!-- Hero Section -->
<section class="hero-section text-center py-5 mb-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 0 0 30px 30px;">
    <div class="container">
        <h1 class="display-3 fw-bold mb-3">🎓 تعلم اللغات بكل سهولة</h1>
        <p class="lead mb-4">منصة متكاملة لتعلم اللغات مع كورسات مسجلة ومباشرة، شهادات معتمدة، وتحديد مستوى دقيق</p>
        <a href="{{ route('courses.index') }}" class="btn btn-light btn-lg">
            <i class="fas fa-play"></i> ابدأ رحلتك الآن
        </a>
    </div>
</section>

<!-- المميزات -->
<section class="features mb-5">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-md-3">
                <div class="feature-card p-4">
                    <i class="fas fa-video fa-3x text-primary mb-3"></i>
                    <h5>كورسات مسجلة</h5>
                    <p class="text-muted">دروس فيديو عالية الجودة</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="feature-card p-4">
                    <i class="fas fa-chart-line fa-3x text-success mb-3"></i>
                    <h5>تحديد المستوى</h5>
                    <p class="text-muted">اختبار لتحديد مستواك بدقة</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="feature-card p-4">
                    <i class="fas fa-certificate fa-3x text-warning mb-3"></i>
                    <h5>شهادات معتمدة</h5>
                    <p class="text-muted">احصل على شهادة بعد كل كورس</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="feature-card p-4">
                    <i class="fas fa-envelope fa-3x text-info mb-3"></i>
                    <h5>كلمة يومية</h5>
                    <p class="text-muted">كلمة تحفيزية يومية على بريدك</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- أحدث الكورسات -->
<section class="latest-courses mb-5">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="fw-bold">📚 أحدث الكورسات</h2>
            <p class="text-muted">اكتشف أحدث الكورسات المضافة إلى منصتنا</p>
        </div>
        
        <div class="row">
            @forelse($latestCourses as $course)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        @if($course->image)
                            <img src="{{ asset('storage/' . $course->image) }}" class="card-img-top" alt="{{ $course->title_ar }}" style="height: 200px; object-fit: cover;">
                        @else
                            <div class="bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="fas fa-book fa-4x text-white"></i>
                            </div>
                        @endif
                        
                        <div class="card-body">
                            <h5 class="card-title">{{ $course->title_ar }}</h5>
                            <p class="card-text text-muted">{{ Str::limit($course->description_ar, 80) }}</p>
                            
                            @if($course->level)
                                <span class="badge bg-info mb-2">
                                    <i class="fas fa-chart-line"></i> {{ $course->level->name_ar }}
                                </span>
                            @endif
                            
                            <div class="course-price mt-2">
                                @if($course->price > 0)
                                    <span class="fw-bold text-primary">{{ number_format($course->price, 2) }} $</span>
                                @else
                                    <span class="fw-bold text-success">مجاني</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="card-footer bg-transparent border-0 pb-3">
                            <a href="{{ route('courses.show', $course->id) }}" class="btn btn-outline-primary w-100">
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
        
        <div class="text-center mt-3">
            <a href="{{ route('courses.index') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-th-list"></i> جميع الكورسات
            </a>
        </div>
    </div>
</section>

<!-- المستويات -->
<section class="levels bg-light py-5 mb-5" style="border-radius: 20px;">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="fw-bold">📊 المستويات</h2>
            <p class="text-muted">اختر المستوى المناسب لك</p>
        </div>
        
        <div class="row g-3 text-center">
            @foreach($levels as $level)
                <div class="col-md-2 col-6">
                    <div class="level-card p-3 bg-white rounded shadow-sm">
                        <i class="fas fa-chart-line fa-2x text-primary mb-2"></i>
                        <h6>{{ $level->name_ar }}</h6>
                        <small class="text-muted">{{ $level->name_en }}</small>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- إحصائيات سريعة -->
<section class="stats mb-5">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-md-4">
                <div class="stat-card p-4 bg-primary text-white rounded">
                    <i class="fas fa-book fa-3x mb-2"></i>
                    <h2 class="fw-bold">{{ $stats['courses_count'] }}</h2>
                    <p>كورس تعليمي</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card p-4 bg-success text-white rounded">
                    <i class="fas fa-users fa-3x mb-2"></i>
                    <h2 class="fw-bold">{{ $stats['students_count'] }}</h2>
                    <p>طالب مسجل</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card p-4 bg-warning text-white rounded">
                    <i class="fas fa-certificate fa-3x mb-2"></i>
                    <h2 class="fw-bold">{{ $stats['certificates_count'] }}</h2>
                    <p>شهادة صادرة</p>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .feature-card, .level-card {
        transition: transform 0.3s ease;
    }
    .feature-card:hover, .level-card:hover {
        transform: translateY(-5px);
    }
    .stat-card {
        transition: transform 0.3s ease;
    }
    .stat-card:hover {
        transform: scale(1.05);
    }
    .hero-section {
        margin-top: -20px;
    }
</style>
@endsection