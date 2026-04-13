@extends('layouts.master')

@section('title', __('messages.reset_password'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-warning text-dark text-center rounded-top-4 py-4">
                <i class="fas fa-key fa-2x mb-2"></i>
                <h4 class="mb-0">{{ __('messages.reset_password') }}</h4>
                <p class="small text-muted mb-0">{{ __('messages.create_new_password') }}</p>
            </div>
            
            <div class="card-body p-4">
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    
                    <input type="hidden" name="token" value="{{ $token }}">
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('messages.email') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-envelope text-muted"></i>
                            </span>
                            <input id="email" type="email" class="form-control border-start-0 @error('email') is-invalid @enderror" 
                                   name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus
                                   placeholder="{{ __('messages.email_placeholder') }}">
                        </div>
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('messages.new_password') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-lock text-muted"></i>
                            </span>
                            <input id="password" type="password" class="form-control border-start-0 @error('password') is-invalid @enderror" 
                                   name="password" required autocomplete="new-password"
                                   placeholder="{{ __('messages.new_password_placeholder') }}">
                        </div>
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="password-confirm" class="form-label">{{ __('messages.confirm_new_password') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-check-circle text-muted"></i>
                            </span>
                            <input id="password-confirm" type="password" class="form-control border-start-0" 
                                   name="password_confirmation" required autocomplete="new-password"
                                   placeholder="{{ __('messages.confirm_new_password_placeholder') }}">
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-warning btn-lg py-2">
                            <i class="fas fa-save me-2"></i> {{ __('messages.reset_password_button') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection