@extends('layouts.master')

@section('title', 'اختبار تحديد المستوى')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">
                    <i class="fas fa-chart-line"></i> اختبار تحديد المستوى
                </h3>
            </div>
            
            <div class="card-body text-center">
                <div class="mb-4">
                    <i class="fas fa-language fa-4x text-primary mb-3"></i>
                    <h4>مرحباً بك في اختبار تحديد المستوى</h4>
                    <p class="text-muted">
                        هذا الاختبار مكون من <strong>{{ $questionsCount }}</strong> سؤال.
                        سيتم تحديد مستواك بناءً على إجاباتك.
                    </p>
                </div>
                
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <strong>نصائح قبل البدء:</strong>
                    <ul class="mt-2 text-end">
                        <li>اقرأ كل سؤال بعناية</li>
                        <li>اختر الإجابة الأنسب</li>
                        <li>لا يمكنك تغيير الإجابات بعد الإرسال</li>
                    </ul>
                </div>
                
                <a href="{{ route('placement-test.start') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-play"></i> بدء الاختبار
                </a>
            </div>
        </div>
    </div>
</div>
@endsection