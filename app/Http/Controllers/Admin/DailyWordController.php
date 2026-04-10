<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DailyWordStoreRequest;
use App\Http\Requests\DailyWordUpdateRequest;
use App\Models\DailyWord;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class DailyWordController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(): View
    {
        $words = DailyWord::orderBy('scheduled_for', 'desc')->paginate(15);
        return view('admin.daily-words.index', compact('words'));
    }

    public function create(): View
    {
        return view('admin.daily-words.create');
    }

    public function store(DailyWordStoreRequest $request): RedirectResponse
    {
        DailyWord::create($request->validated());

        return redirect()
            ->route('admin.daily-words.index')
            ->with('success', 'تم إضافة الكلمة بنجاح');
    }

    public function edit(DailyWord $dailyWord): View
    {
        return view('admin.daily-words.edit', compact('dailyWord'));
    }

    public function update(DailyWordUpdateRequest $request, DailyWord $dailyWord): RedirectResponse
    {
        $dailyWord->update($request->validated());

        return redirect()
            ->route('admin.daily-words.index')
            ->with('success', 'تم تحديث الكلمة بنجاح');
    }

    public function destroy(DailyWord $dailyWord): RedirectResponse
    {
        $dailyWord->delete();

        return redirect()
            ->route('admin.daily-words.index')
            ->with('success', 'تم حذف الكلمة بنجاح');
    }
}