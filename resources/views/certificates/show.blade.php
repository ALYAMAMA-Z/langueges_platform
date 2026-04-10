@extends('layouts.master')

@section('title', __('messages.certificate') . ' - ' . (LaravelLocalization::getCurrentLocale() == 'ar' ? $certificate->course->title_ar : $certificate->course->title_en))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0 text-center">
                    <i class="fas fa-certificate"></i> {{ __('messages.certificate_of_completion') }}
                </h3>
            </div>
            
            <div class="card-body text-center">
                <div class="certificate-preview p-4 border rounded mb-4">
                    <h2 class="mb-4">{{ __('messages.certificate_title') }}</h2>
                    <p>{{ __('messages.this_certificate_awards') }}</p>
                    <h3 class="fw-bold">{{ $certificate->user->name }}</h3>
                    <p>{{ __('messages.for_completing') }}</p>
                    <h4 class="text-primary">{{ LaravelLocalization::getCurrentLocale() == 'ar' ? $certificate->course->title_ar : $certificate->course->title_en }}</h4>
                    <p class="mt-4">
                        {{ __('messages.on_date') }}: {{ $certificate->issued_at->format('d / m / Y') }}
                    </p>
                    <div class="mt-4">
                        <i class="fas fa-signature fa-2x text-muted"></i>
                        <p class="text-muted">{{ __('messages.platform_management') }}</p>
                    </div>
                </div>
                
                <div class="text-center">
                    <a href="{{ route('certificates.download', $certificate->id) }}" class="btn btn-success btn-lg">
                        <i class="fas fa-download"></i> {{ __('messages.download_pdf') }}
                    </a>
                    <a href="{{ route('certificates.index') }}" class="btn btn-secondary btn-lg">
                        <i class="fas fa-arrow-right"></i> {{ __('messages.all_certificates') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .certificate-preview {
        background: linear-gradient(145deg, #fff 0%, #f8f9fa 100%);
        border: 2px solid #3498db !important;
    }
</style>
@endsection