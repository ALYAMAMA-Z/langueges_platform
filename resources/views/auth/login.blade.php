@extends('layouts.master')

@section('title', __('messages.login'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-primary text-white text-center rounded-top-4 py-4">
                <i class="fas fa-sign-in-alt fa-2x mb-2"></i>
                <h4 class="mb-0">{{ __('messages.login') }}</h4>
                <p class="small text-white-50 mb-0">{{ __('messages.welcome_back') }}</p>
            </div>
            
            <div class="card-body p-4">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="mb-3">
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
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('messages.password') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-lock text-muted"></i>
                            </span>
                            <input id="password" type="password" class="form-control border-start-0 @error('password') is-invalid @enderror" 
                                   name="password" required autocomplete="current-password"
                                   placeholder="{{ __('messages.password_placeholder') }}">
                        </div>
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3 form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            {{ __('messages.remember_me') }}
                        </label>
                    </div>
                    
                    <div class="d-grid gap-2 mb-3">
                        <button type="submit" class="btn btn-primary btn-lg py-2">
                            <i class="fas fa-sign-in-alt me-2"></i> {{ __('messages.login') }}
                        </button>
                    </div>
                    
                    <div class="text-center">
                        @if (Route::has('password.request'))
                            <a class="text-decoration-none small" href="{{ route('password.request') }}">
                                <i class="fas fa-key me-1"></i> {{ __('messages.forgot_password') }}
                            </a>
                        @endif
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="text-center">
                        <p class="mb-0">{{ __('messages.dont_have_account') }}
                            <a href="{{ route('register') }}" class="text-primary fw-bold text-decoration-none">
                                {{ __('messages.register') }} <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection