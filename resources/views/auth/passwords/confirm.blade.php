@extends('layouts.master')

@section('title', __('messages.confirm_password'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-secondary text-white text-center rounded-top-4 py-4">
                <i class="fas fa-shield-alt fa-2x mb-2"></i>
                <h4 class="mb-0">{{ __('messages.confirm_password') }}</h4>
                <p class="small text-white-50 mb-0">{{ __('messages.confirm_password_subtitle') }}</p>
            </div>
            
            <div class="card-body p-4">
                <p class="text-muted mb-4">{{ __('messages.confirm_password_instruction') }}</p>
                
                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf
                    
                    <div class="mb-4">
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
                    
                    <div class="d-grid gap-2 mb-3">
                        <button type="submit" class="btn btn-secondary btn-lg py-2">
                            <i class="fas fa-check-circle me-2"></i> {{ __('messages.confirm_password_button') }}
                        </button>
                    </div>
                    
                    <div class="text-center">
                        @if (Route::has('password.request'))
                            <a class="text-decoration-none small" href="{{ route('password.request') }}">
                                <i class="fas fa-key me-1"></i> {{ __('messages.forgot_password') }}
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection