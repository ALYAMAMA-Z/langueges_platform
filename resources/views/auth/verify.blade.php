@extends('layouts.master')

@section('title', __('messages.verify_email'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-warning text-dark text-center rounded-top-4 py-4">
                <i class="fas fa-envelope fa-2x mb-2"></i>
                <h4 class="mb-0">{{ __('messages.verify_email') }}</h4>
                <p class="small text-muted mb-0">{{ __('messages.verify_email_subtitle') }}</p>
            </div>
            
            <div class="card-body p-4 text-center">
                @if (session('resent'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i> {{ __('messages.verification_link_sent') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                <i class="fas fa-envelope-open-text fa-4x text-warning mb-4"></i>
                
                <p class="mb-3">{{ __('messages.verification_message') }}</p>
                
                <p class="text-muted mb-4">
                    {{ __('messages.verification_instruction') }}
                </p>
                
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    {{ __('messages.verification_not_received') }}
                </div>
                
                <form method="POST" action="{{ route('verification.resend') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-lg px-4">
                        <i class="fas fa-paper-plane me-2"></i> {{ __('messages.request_new_link') }}
                    </button>
                </form>
                
                <hr class="my-4">
                
                <div class="text-center">
                    <a href="{{ route('logout') }}" class="text-danger text-decoration-none"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt me-1"></i> {{ __('messages.logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection