@extends('layouts.master')

@section('title', __('messages.placement_test_title'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">
                    <i class="fas fa-chart-line"></i> {{ __('messages.placement_test_title') }}
                </h3>
            </div>
            
            <div class="card-body text-center">
                <div class="mb-4">
                    <i class="fas fa-language fa-4x text-primary mb-3"></i>
                    <h4>{{ __('messages.placement_test_welcome') }}</h4>
                    <p class="text-muted">
                        {{ __('messages.placement_test_description') }}
                        <strong>{{ $questionsCount }} {{ __('messages.questions') }}</strong>
                    </p>
                </div>
                
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <strong>{{ __('messages.placement_test_tips_title') }}</strong>
                    <ul class="mt-2 text-end">
                        <li>{{ __('messages.placement_test_tip1') }}</li>
                        <li>{{ __('messages.placement_test_tip2') }}</li>
                        <li>{{ __('messages.placement_test_tip3') }}</li>
                    </ul>
                </div>
                
                <a href="{{ route('placement-test.start') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-play"></i> {{ __('messages.start_test') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection