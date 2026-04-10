@extends('layouts.master')

@section('title', __('messages.payment'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-warning">
                <h4 class="mb-0">
                    <i class="fas fa-credit-card"></i> {{ __('messages.payment') }}
                </h4>
            </div>
            
            <div class="card-body text-center">
                <div class="mb-4">
                    <i class="fas fa-clock fa-4x text-warning mb-3"></i>
                    <h4>{{ __('messages.waiting_for_payment') }}</h4>
                    <p class="text-muted">
                        {{ __('messages.waiting_for_payment_message') }}
                    </p>
                </div>
                
                <div class="alert alert-info">
                    <strong>{{ __('messages.payment_details') }}:</strong><br>
                    {{ __('messages.course') }}: {{ LaravelLocalization::getCurrentLocale() == 'ar' ? $enrollment->course->title_ar : $enrollment->course->title_en }}<br>
                    {{ __('messages.amount') }}: {{ number_format($enrollment->course->price, 2) }} $<br>
                    {{ __('messages.payment_method') }}: {{ $enrollment->payment_method == 'paypal' ? __('messages.paypal') : __('messages.bank_transfer') }}
                </div>
                
                @if($enrollment->payment_method == 'paypal')
                    <a href="{{ route('paypal.process', $enrollment->id) }}" class="btn btn-primary btn-lg">
                        <i class="fab fa-paypal"></i> {{ __('messages.pay_with_paypal') }}
                    </a>
                @else
                    <div class="alert alert-secondary">
                        <i class="fas fa-info-circle"></i>
                        {{ __('messages.bank_transfer_instructions') }}<br>
                        <strong>IBAN: XX00 0000 0000 0000 0000 000</strong><br>
                        {{ __('messages.bank_transfer_activation') }}
                    </div>
                @endif
                
                <div class="mt-3">
                    <a href="{{ route('courses.show', $enrollment->course->id) }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-right"></i> {{ __('messages.back_to_course') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection