@extends('layouts.master')

@section('title', 'لا توجد أسئلة')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-warning">
                <h3 class="mb-0">
                    <i class="fas fa-exclamation-triangle"></i> لا توجد أسئلة
                </h3>
            </div>
            
            <div class="card-body text-center">
                <i class="fas fa-database fa-5x text-muted mb-3"></i>
                <p class="lead">لا توجد أسئلة في قاعدة البيانات بعد.</p>
                <p>الرجاء التواصل مع المدير لإضافة أسئلة الاختبار.</p>
            </div>
        </div>
    </div>
</div>
@endsection