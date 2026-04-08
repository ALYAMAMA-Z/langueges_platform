<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseStoreRequest;
use App\Http\Requests\CourseUpdateRequest;
use App\Services\CourseService;
//use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CourseController extends Controller
{
    protected CourseService $courseService;

    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
    }

    /**
     * عرض قائمة الكورسات
     */
    public function index(): View
    {
        $courses = $this->courseService->getAllCourses();
        return view('courses.index', compact('courses'));
    }

    /**
     * عرض صفحة إنشاء كورس جديد
     */
    public function create(): View
    {
        $levels = \App\Models\Level::all();
        return view('courses.create', compact('levels'));
    }

    /**
     * تخزين كورس جديد في قاعدة البيانات
     */
    public function store(CourseStoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // معالجة رفع الصورة إذا وجدت
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('courses', 'public');
        }

        $course = $this->courseService->createCourse($validated);

        return redirect()
            ->route('courses.show', $course->id)
            ->with('success', 'تم إنشاء الكورس بنجاح');
    }

    /**
     * عرض كورس محدد
     */
    public function show(int $id): View
    {
        $course = $this->courseService->getCourseById($id);
        return view('courses.show', compact('course'));
    }

    /**
     * عرض صفحة تعديل كورس
     */
    public function edit(int $id): View
    {
        $course = $this->courseService->getCourseById($id);
          $levels = \App\Models\Level::all();
        return view('courses.edit', compact('course', 'levels'));
    }

    /**
     * تحديث كورس
     */
    public function update(CourseUpdateRequest $request, int $id): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('courses', 'public');
        }

        $course = $this->courseService->updateCourse($id, $validated);

        return redirect()
            ->route('courses.show', $course->id)
            ->with('success', 'تم تحديث الكورس بنجاح');
    }

    /**
     * حذف كورس
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->courseService->deleteCourse($id);

        return redirect()
            ->route('courses.index')
            ->with('success', 'تم حذف الكورس بنجاح');
    }
}