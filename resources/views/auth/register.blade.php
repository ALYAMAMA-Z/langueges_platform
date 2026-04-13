@extends('layouts.master')

@section('title', __('messages.register'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-success text-white text-center rounded-top-4 py-4">
                <i class="fas fa-user-plus fa-2x mb-2"></i>
                <h4 class="mb-0">{{ __('messages.register') }}</h4>
                <p class="small text-white-50 mb-0">{{ __('messages.create_account') }}</p>
            </div>
            
            <div class="card-body p-4">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('messages.name') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-user text-muted"></i>
                            </span>
                            <input id="name" type="text" class="form-control border-start-0 @error('name') is-invalid @enderror" 
                                   name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                                   placeholder="{{ __('messages.name_placeholder') }}">
                        </div>
                        @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('messages.email') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-envelope text-muted"></i>
                            </span>
                            <input id="email" type="email" class="form-control border-start-0 @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email') }}" required autocomplete="email"
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
                                   name="password" required autocomplete="new-password"
                                   placeholder="{{ __('messages.password_placeholder') }}">
                        </div>
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="password-confirm" class="form-label">{{ __('messages.confirm_password') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-check-circle text-muted"></i>
                            </span>
                            <input id="password-confirm" type="password" class="form-control border-start-0" 
                                   name="password_confirmation" required autocomplete="new-password"
                                   placeholder="{{ __('messages.confirm_password_placeholder') }}">
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2 mb-3">
                        <button type="submit" class="btn btn-success btn-lg py-2">
                            <i class="fas fa-user-plus me-2"></i> {{ __('messages.register') }}
                        </button>
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="text-center">
                        <p class="mb-0">{{ __('messages.already_have_account') }}
                            <a href="{{ route('login') }}" class="text-primary fw-bold text-decoration-none">
                                {{ __('messages.login') }} <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection