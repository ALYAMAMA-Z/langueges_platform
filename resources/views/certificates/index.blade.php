@extends('layouts.master')

@section('title', __('messages.my_certificates'))

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h2 class="fw-bold">
            <i class="fas fa-certificate"></i> {{ __('messages.my_certificates') }}
        </h2>
        <p class="text-muted">{{ __('messages.certificates_description') }}</p>
    </div>
</div>

@if($certificates->count() > 0)
    <div class="row">
        @foreach($certificates as $certificate)
            <div class="col-md-4 mb-4">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <i class="fas fa-certificate fa-4x text-primary mb-3"></i>
                        <h5 class="card-title">{{ LaravelLocalization::getCurrentLocale() == 'ar' ? $certificate->course->title_ar : $certificate->course->title_en }}</h5>
                        <p class="text-muted">
                            {{ __('messages.issued_date') }}: {{ $certificate->issued_at->format('Y-m-d') }}
                        </p>
                    </div>
                    <div class="card-footer bg-transparent border-0 pb-3">
                        <a href="{{ route('certificates.show', $certificate->id) }}" class="btn btn-primary">
                            <i class="fas fa-eye"></i> {{ __('messages.view_certificate') }}
                        </a>
                        <a href="{{ route('certificates.download', $certificate->id) }}" class="btn btn-success">
                            <i class="fas fa-download"></i> {{ __('messages.download_pdf') }}
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="alert alert-info text-center">
        <i class="fas fa-info-circle"></i> {{ __('messages.no_certificates') }}
    </div>
@endif
@endsection