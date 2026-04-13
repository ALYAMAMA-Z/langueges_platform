<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LessonStoreRequest;
use App\Http\Requests\LessonUpdateRequest;
use App\Services\LessonService;
use App\Services\CourseService;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class LessonController extends Controller
{
    protected LessonService $lessonService;
    protected CourseService $courseService;

    public function __construct(LessonService $lessonService, CourseService $courseService)
    {
        $this->lessonService = $lessonService;
        $this->courseService = $courseService;
    }

    /**
     * عرض قائمة الدروس لكورس معين
     */
    public function index(int $courseId): View
    {
        $course = $this->courseService->getCourseById($courseId);
        $lessons = $this->lessonService->getLessonsByCourse($courseId);
        
        return view('lessons.index', compact('course', 'lessons'));
    }

    /**
     * عرض صفحة إنشاء درس جديد
     */
    public function create(int $courseId): View
    {
        $course = $this->courseService->getCourseById($courseId);
        return view('lessons.create', compact('course'));
    }

    /**
     * تخزين درس جديد
     */
  public function store(LessonStoreRequest $request, int $courseId): RedirectResponse
{
    $validated = $request->validated();
    $validated['course_id'] = $courseId;
    $validated['is_live'] = $request->has('is_live');
    
    // ✅ أضيفي هذه الأسطر
    if ($request->has('is_live')) {
        $validated['live_platform'] = $request->live_platform;
        $validated['live_join_url'] = $request->live_join_url;
        $validated['live_start_time'] = $request->live_start_time;
        $validated['live_duration'] = $request->live_duration;
    }
    
    $lesson = $this->lessonService->createLesson($validated);

    return redirect()
        ->route('courses.lessons.index', $courseId)
        ->with('success', 'تم إنشاء الدرس بنجاح');
}

    /**
     * عرض درس محدد
     */
    public function show(int $courseId, int $lessonId): View
    {
        $course = $this->courseService->getCourseById($courseId);
        $lesson = $this->lessonService->getLessonById($lessonId);
        
        return view('lessons.show', compact('course', 'lesson'));
    }

    /**
     * عرض صفحة تعديل درس
     */
    public function edit(int $courseId, int $lessonId): View
    {
        $course = $this->courseService->getCourseById($courseId);
        $lesson = $this->lessonService->getLessonById($lessonId);
        
        return view('lessons.edit', compact('course', 'lesson'));
    }

    /**
     * تحديث درس
     */
   public function update(LessonUpdateRequest $request, int $courseId, int $lessonId): RedirectResponse
{
    $validated = $request->validated();
    $validated['is_live'] = $request->has('is_live');
    
    // ✅ أضيفي هذه الأسطر
    if ($request->has('is_live')) {
        $validated['live_platform'] = $request->live_platform;
        $validated['live_join_url'] = $request->live_join_url;
        $validated['live_start_time'] = $request->live_start_time;
        $validated['live_duration'] = $request->live_duration;
    } else {
        $validated['live_platform'] = null;
        $validated['live_join_url'] = null;
        $validated['live_start_time'] = null;
        $validated['live_duration'] = null;
    }
    
    $this->lessonService->updateLesson($lessonId, $validated);

    return redirect()
        ->route('courses.lessons.index', $courseId)
        ->with('success', 'تم تحديث الدرس بنجاح');
}

    /**
     * حذف درس
     */
    public function destroy(int $courseId, int $lessonId): RedirectResponse
    {
        $this->lessonService->deleteLesson($lessonId);

        return redirect()
            ->route('courses.lessons.index', $courseId)
            ->with('success', 'تم حذف الدرس بنجاح');
    }
}
