@extends('layouts.master')

@section('title', __('messages.reset_password'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-info text-white text-center rounded-top-4 py-4">
                <i class="fas fa-key fa-2x mb-2"></i>
                <h4 class="mb-0">{{ __('messages.reset_password') }}</h4>
                <p class="small text-white-50 mb-0">{{ __('messages.reset_password_subtitle') }}</p>
            </div>
            
            <div class="card-body p-4">
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i> {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                <p class="text-muted mb-4">{{ __('messages.reset_password_instruction') }}</p>
                
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="email" class="form-label">{{ __('messages.email') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-envelope text-muted"></i>
                            </span>
                            <input id="email" type="email" class="form-control border-start-0 @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                   placeholder="{{ __('messages.email_placeholder') }}">
                        </div>
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-grid gap-2 mb-3">
                        <button type="submit" class="btn btn-info btn-lg py-2 text-white">
                            <i class="fas fa-paper-plane me-2"></i> {{ __('messages.send_reset_link') }}
                        </button>
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="text-center">
                        <a href="{{ route('login') }}" class="text-decoration-none">
                            <i class="fas fa-arrow-right me-1"></i> {{ __('messages.back_to_login') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection