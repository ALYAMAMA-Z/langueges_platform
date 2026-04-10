@extends('layouts.master')

@section('title', __('messages.no_questions_title'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-warning">
                <h3 class="mb-0">
                    <i class="fas fa-exclamation-triangle"></i> {{ __('messages.no_questions_title') }}
                </h3>
            </div>
            
            <div class="card-body text-center">
                <i class="fas fa-database fa-5x text-muted mb-3"></i>
                <p class="lead">{{ __('messages.no_questions_message') }}</p>
                <p>{{ __('messages.no_questions_contact') }}</p>
                
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.daily-words.index') }}" class="btn btn-primary mt-3">
                            <i class="fas fa-plus"></i> {{ __('messages.add_questions') }}
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection