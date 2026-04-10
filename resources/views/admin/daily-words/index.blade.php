@extends('layouts.master')

@section('title', __('messages.manage_daily_words'))

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h2 class="fw-bold">
            <i class="fas fa-calendar-day"></i> {{ __('messages.manage_daily_words') }}
        </h2>
        <p class="text-muted">{{ __('messages.daily_words_description') }}</p>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('admin.daily-words.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> {{ __('messages.add_new_word') }}
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($words->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('messages.word_en') }}</th>
                            <th>{{ __('messages.word_ar') }}</th>
                            <th>{{ __('messages.scheduled_date') }}</th>
                            <th>{{ __('messages.status') }}</th>
                            <th>{{ __('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($words as $word)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><strong>{{ $word->word_en }}</strong></td>
                                <td>{{ $word->word_ar }}</td>
                                <td>{{ $word->scheduled_for->format('Y-m-d') }}</td>
                                <td>
                                    @if($word->is_sent)
                                        <span class="badge bg-success">{{ __('messages.sent') }}</span>
                                    @elseif($word->scheduled_for->isToday())
                                        <span class="badge bg-warning">{{ __('messages.pending') }}</span>
                                    @else
                                        <span class="badge bg-secondary">{{ __('messages.scheduled') }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.daily-words.edit', $word) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> {{ __('messages.edit') }}
                                    </a>
                                    <form action="{{ route('admin.daily-words.destroy', $word) }}" method="POST" class="d-inline" onsubmit="return confirm(__('messages.are_you_sure'))">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i> {{ __('messages.delete') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $words->links() }}
        @else
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle"></i> {{ __('messages.no_words') }}
            </div>
        @endif
    </div>
</div>
@endsection