@extends('layouts.master')

@section('title', 'أسئلة تحديد المستوى')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">
                    <i class="fas fa-question-circle"></i> أجب على الأسئلة التالية
                </h4>
            </div>
            
            <div class="card-body">
                <form action="{{ route('placement-test.submit') }}" method="POST" id="testForm">
                    @csrf
                    
                    @foreach($questions as $index => $question)
                        <div class="question-box mb-4 p-3 border rounded">
                            <h5 class="mb-3">
                                <span class="badge bg-secondary rounded-pill me-2">{{ $index + 1 }}</span>
                                {{ $question->question_text_ar }}
                            </h5>
                            
                            <div class="options">
                                <div class="form-check mb-2">
                                    <input type="radio" name="answers[{{ $question->id }}]" value="a" 
                                           class="form-check-input" id="q{{ $question->id }}_a" required>
                                    <label class="form-check-label" for="q{{ $question->id }}_a">
                                        أ. {{ $question->option_a_ar }}
                                    </label>
                                </div>
                                
                                <div class="form-check mb-2">
                                    <input type="radio" name="answers[{{ $question->id }}]" value="b" 
                                           class="form-check-input" id="q{{ $question->id }}_b" required>
                                    <label class="form-check-label" for="q{{ $question->id }}_b">
                                        ب. {{ $question->option_b_ar }}
                                    </label>
                                </div>
                                
                                @if($question->option_c_ar)
                                    <div class="form-check mb-2">
                                        <input type="radio" name="answers[{{ $question->id }}]" value="c" 
                                               class="form-check-input" id="q{{ $question->id }}_c" required>
                                        <label class="form-check-label" for="q{{ $question->id }}_c">
                                            ج. {{ $question->option_c_ar }}
                                        </label>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                    
                    <div class="text-center">
                        <button type="submit" class="btn btn-success btn-lg" onclick="return confirm('هل أنت متأكد من إجاباتك؟')">
                            <i class="fas fa-check-circle"></i> إنهاء الاختبار وتحديد مستواي
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .question-box {
        background-color: #f8f9fa;
        transition: transform 0.2s;
    }
    .question-box:hover {
        transform: translateX(5px);
        background-color: #e9ecef;
    }
</style>
@endsection