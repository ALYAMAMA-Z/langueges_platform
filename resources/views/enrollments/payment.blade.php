@extends('layouts.master')

@section('title', 'إتمام الدفع')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-warning">
                <h4 class="mb-0">
                    <i class="fas fa-credit-card"></i> إتمام الدفع
                </h4>
            </div>
            
            <div class="card-body text-center">
                <div class="mb-4">
                    <i class="fas fa-clock fa-4x text-warning mb-3"></i>
                    <h4>في انتظار الدفع</h4>
                    <p class="text-muted">
                        سيتم تفعيل الكورس بعد تأكيد عملية الدفع.
                    </p>
                </div>
                
                <div class="alert alert-info">
                    <strong>معلومات الدفع:</strong><br>
                    الكورس: {{ $enrollment->course->title_ar }}<br>
                    المبلغ: {{ number_format($enrollment->course->price, 2) }} $<br>
                    طريقة الدفع: {{ $enrollment->payment_method == 'paypal' ? 'PayPal' : 'تحويل بنكي' }}
                </div>
                
                @if($enrollment->payment_method == 'paypal')
                    <button class="btn btn-primary btn-lg" id="paypal-button">
                        <i class="fab fa-paypal"></i> الدفع عبر PayPal
                    </button>
                @else
                    <div class="alert alert-secondary">
                        <i class="fas fa-info-circle"></i>
                        الرجاء تحويل المبلغ إلى الحساب التالي:<br>
                        <strong>IBAN: XX00 0000 0000 0000 0000 000</strong><br>
                        سيتم تفعيل الكورس بعد تأكيد الدفع من قبل الإدارة.
                    </div>
                @endif
                
                <div class="mt-3">
                    <a href="{{ route('courses.show', $enrollment->course->id) }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-right"></i> العودة للكورس
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection