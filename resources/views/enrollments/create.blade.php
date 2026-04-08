@extends('layouts.master')

@section('title', 'تسجيل في كورس: ' . $course->title_ar)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">
                    <i class="fas fa-shopping-cart"></i> تسجيل في كورس
                </h4>
            </div>
            
            <div class="card-body">
                <div class="text-center mb-4">
                    <h3>{{ $course->title_ar }}</h3>
                    <div class="course-price mt-2">
                        @if($course->price > 0)
                            <span class="display-6 fw-bold text-primary">{{ number_format($course->price, 2) }} $</span>
                        @else
                            <span class="display-6 fw-bold text-success">مجاني</span>
                        @endif
                    </div>
                </div>
                
                <form action="{{ route('enrollments.store', $course->id) }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">اختر طريقة الدفع:</label>
                        <div class="form-check mb-2">
                            <input type="radio" name="payment_method" value="paypal" id="paypal" class="form-check-input" required>
                            <label for="paypal" class="form-check-label">
                                <i class="fab fa-paypal text-primary"></i> PayPal
                            </label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="payment_method" value="manual" id="manual" class="form-check-input">
                            <label for="manual" class="form-check-label">
                                <i class="fas fa-building-columns"></i> تحويل بنكي (يدوي)
                            </label>
                            <small class="text-muted d-block">سيتم تفعيل الكورس بعد تأكيد الدفع من قبل الإدارة</small>
                        </div>
                        @error('payment_method')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="text-end">
                        <a href="{{ route('courses.show', $course->id) }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> إلغاء
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check-circle"></i> تأكيد التسجيل
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection