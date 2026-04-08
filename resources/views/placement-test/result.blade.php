@extends('layouts.master')

@section('title', 'نتيجة اختبار تحديد المستوى')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h3 class="mb-0">
                    <i class="fas fa-trophy"></i> نتيجة اختبار تحديد المستوى
                </h3>
            </div>
            
            <div class="card-body text-center">
                <div class="mb-4">
                    <i class="fas fa-chart-line fa-5x text-primary mb-3"></i>
                    
                    <h4>مستواك هو:</h4>
                    <div class="display-4 fw-bold text-primary my-3">
                        {{ $result->level->name_ar }}
                    </div>
                    <p class="lead">{{ $result->level->name_en }}</p>
                    
                    <div class="alert alert-info mt-4">
                        <i class="fas fa-star"></i>
                        <strong>نتيجتك:</strong>
                        {{ $result->score }} / {{ App\Models\Question::count() }} إجابة صحيحة
                    </div>
                </div>
                
                <div class="alert alert-success">
                    <i class="fas fa-info-circle"></i>
                    بناءً على مستواك، يمكنك الاشتراك في الكورسات المناسبة لك.
                </div>
                
                <a href="{{ route('courses.index') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-book"></i> استعرض الكورسات المناسبة لمستواك
                </a>
            </div>
        </div>
    </div>
</div>
@endsection