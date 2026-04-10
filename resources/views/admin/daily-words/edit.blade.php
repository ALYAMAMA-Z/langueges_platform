@extends('layouts.master')

@section('title', __('messages.edit_word') . ': ' . $dailyWord->word_en)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-warning">
                <h4 class="mb-0">
                    <i class="fas fa-edit"></i> {{ __('messages.edit_word') }}: {{ $dailyWord->word_en }}
                </h4>
            </div>
            
            <div class="card-body">
                <form action="{{ route('admin.daily-words.update', $dailyWord) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="word_en" class="form-label">{{ __('messages.word_en') }} *</label>
                            <input type="text" name="word_en" id="word_en" class="form-control @error('word_en') is-invalid @enderror" value="{{ old('word_en', $dailyWord->word_en) }}" required>
                            @error('word_en')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="word_ar" class="form-label">{{ __('messages.word_ar') }} *</label>
                            <input type="text" name="word_ar" id="word_ar" class="form-control @error('word_ar') is-invalid @enderror" value="{{ old('word_ar', $dailyWord->word_ar) }}" required>
                            @error('word_ar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="definition_en" class="form-label">{{ __('messages.definition_en') }} *</label>
                            <textarea name="definition_en" id="definition_en" rows="3" class="form-control @error('definition_en') is-invalid @enderror" required>{{ old('definition_en', $dailyWord->definition_en) }}</textarea>
                            @error('definition_en')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="definition_ar" class="form-label">{{ __('messages.definition_ar') }} *</label>
                            <textarea name="definition_ar" id="definition_ar" rows="3" class="form-control @error('definition_ar') is-invalid @enderror" required>{{ old('definition_ar', $dailyWord->definition_ar) }}</textarea>
                            @error('definition_ar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="example_en" class="form-label">{{ __('messages.example_en') }} *</label>
                            <textarea name="example_en" id="example_en" rows="2" class="form-control @error('example_en') is-invalid @enderror" required>{{ old('example_en', $dailyWord->example_en) }}</textarea>
                            @error('example_en')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="example_ar" class="form-label">{{ __('messages.example_ar') }} *</label>
                            <textarea name="example_ar" id="example_ar" rows="2" class="form-control @error('example_ar') is-invalid @enderror" required>{{ old('example_ar', $dailyWord->example_ar) }}</textarea>
                            @error('example_ar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="scheduled_for" class="form-label">{{ __('messages.scheduled_date') }} *</label>
                        <input type="date" name="scheduled_for" id="scheduled_for" class="form-control @error('scheduled_for') is-invalid @enderror" value="{{ old('scheduled_for', $dailyWord->scheduled_for->format('Y-m-d')) }}" required>
                        @error('scheduled_for')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="text-end">
                        <a href="{{ route('admin.daily-words.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> {{ __('messages.cancel') }}
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> {{ __('messages.update') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection