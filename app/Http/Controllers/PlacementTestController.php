<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlacementTestRequest;
use App\Services\PlacementTestService;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PlacementTestController extends Controller
{
    protected PlacementTestService $testService;

    public function __construct(PlacementTestService $testService)
    {
        $this->testService = $testService;
    }

    /**
     * عرض صفحة بدء الاختبار
     */
    public function index(): View
    {
        // إذا كان المستخدم قد أجرى الاختبار سابقاً
        if ($this->testService->hasTakenTest(auth()->id())) {
            $result = $this->testService->getUserTestResult(auth()->id());
            return view('placement-test.result', compact('result'));
        }

        $questionsCount = $this->testService->getQuestionsCount();

        // إذا لم توجد أسئلة بعد
        if ($questionsCount === 0) {
            return view('placement-test.no-questions');
        }

        return view('placement-test.start', compact('questionsCount'));
    }

    /**
     * عرض صفحة الأسئلة
     */
    public function start(): View
    {
        // إذا كان المستخدم قد أجرى الاختبار سابقاً
        if ($this->testService->hasTakenTest(auth()->id())) {
            return redirect()->route('placement-test.index');
        }

        $questions = $this->testService->getAllQuestions();

        return view('placement-test.questions', compact('questions'));
    }

    /**
     * معالجة إجابات الاختبار
     */
    public function submit(PlacementTestRequest $request): RedirectResponse
    {
        $result = $this->testService->calculateResult($request->answers, auth()->id());

        return redirect()
            ->route('placement-test.result')
            ->with('success', 'تم تحديد مستواك بنجاح!');
    }

    /**
     * عرض نتيجة الاختبار
     */
    public function result(): View
    {
        $result = $this->testService->getUserTestResult(auth()->id());

        if (!$result) {
            return redirect()->route('placement-test.index');
        }

        return view('placement-test.result', compact('result'));
    }
}