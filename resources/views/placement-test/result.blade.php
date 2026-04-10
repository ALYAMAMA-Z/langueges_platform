@extends('layouts.master')

@section('title', __('messages.placement_test_result'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h3 class="mb-0">
                    <i class="fas fa-trophy"></i> {{ __('messages.placement_test_result') }}
                </h3>
            </div>
            
            <div class="card-body text-center">
                <div class="mb-4">
                    <i class="fas fa-chart-line fa-5x text-primary mb-3"></i>
                    
                    <h4>{{ __('messages.your_level_is') }}</h4>
                    <div class="display-4 fw-bold text-primary my-3">
                        {{ LaravelLocalization::getCurrentLocale() == 'ar' ? $result->level->name_ar : $result->level->name_en }}
                    </div>
                    <p class="lead">{{ LaravelLocalization::getCurrentLocale() == 'ar' ? $result->level->name_en : $result->level->name_ar }}</p>
                    
                    <div class="alert alert-info mt-4">
                        <i class="fas fa-star"></i>
                        <strong>{{ __('messages.your_score') }}</strong>
                        {{ $result->score }} / {{ App\Models\Question::count() }} {{ __('messages.correct_answers') }}
                    </div>
                </div>
                
                <div class="alert alert-success">
                    <i class="fas fa-info-circle"></i>
                    {{ __('messages.level_recommendation') }}
                </div>
                
                <a href="{{ route('courses.index') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-book"></i> {{ __('messages.browse_courses_by_level') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection