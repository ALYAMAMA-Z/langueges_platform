@extends('layouts.master')

@section('title', __('messages.enroll_now') . ' - ' . (LaravelLocalization::getCurrentLocale() == 'ar' ? $course->title_ar : $course->title_en))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">
                    <i class="fas fa-shopping-cart"></i> {{ __('messages.enroll_now') }}
                </h4>
            </div>
            
            <div class="card-body">
                <div class="text-center mb-4">
                    <h3>{{ LaravelLocalization::getCurrentLocale() == 'ar' ? $course->title_ar : $course->title_en }}</h3>
                    <div class="course-price mt-2">
                        @if($course->price > 0)
                            <span class="display-6 fw-bold text-primary">{{ number_format($course->price, 2) }} $</span>
                        @else
                            <span class="display-6 fw-bold text-success">{{ __('messages.free') }}</span>
                        @endif
                    </div>
                </div>
                
                <form action="{{ route('enrollments.store', $course->id) }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.payment_method') }}:</label>
                        <div class="form-check mb-2">
                            <input type="radio" name="payment_method" value="paypal" id="paypal" class="form-check-input" required>
                            <label for="paypal" class="form-check-label">
                                <i class="fab fa-paypal text-primary"></i> {{ __('messages.paypal') }}
                            </label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="payment_method" value="manual" id="manual" class="form-check-input">
                            <label for="manual" class="form-check-label">
                                <i class="fas fa-building-columns"></i> {{ __('messages.bank_transfer') }}
                            </label>
                            <small class="text-muted d-block">{{ __('messages.bank_transfer_help') }}</small>
                        </div>
                        @error('payment_method')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="text-end">
                        <a href="{{ route('courses.show', $course->id) }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> {{ __('messages.cancel') }}
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check-circle"></i> {{ __('messages.confirm_enrollment') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection