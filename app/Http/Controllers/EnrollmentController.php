<?php

namespace App\Http\Controllers;

use App\Http\Requests\EnrollmentRequest;
use App\Services\EnrollmentService;
use App\Services\CourseService;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class EnrollmentController extends Controller
{
    protected EnrollmentService $enrollmentService;
    protected CourseService $courseService;

    public function __construct(EnrollmentService $enrollmentService, CourseService $courseService)
    {
        $this->enrollmentService = $enrollmentService;
        $this->courseService = $courseService;
    }

    /**
     * عرض صفحة التسجيل في كورس
     */
    public function create(int $courseId): View|RedirectResponse
    {
        $course = $this->courseService->getCourseById($courseId);
        
        // التحقق من أن المستخدم غير مسجل بالفعل
        if ($this->enrollmentService->isUserEnrolled(auth()->id(), $courseId)) {
            return redirect()
                ->route('courses.show', $courseId)
                ->with('error', 'أنت مسجل بالفعل في هذا الكورس');
        }

        return view('enrollments.create', compact('course'));
    }

    /**
     * تسجيل في كورس
     */
    public function store(EnrollmentRequest $request, int $courseId): RedirectResponse
    {
        try {
            $enrollment = $this->enrollmentService->enrollUser(
                auth()->id(),
                $courseId,
                $request->payment_method
            );

            // إذا كان الكورس مجاني، يتم التفعيل فوراً
            if ($enrollment->status === 'active') {
                return redirect()
                    ->route('courses.show', $courseId)
                    ->with('success', 'تم التسجيل في الكورس بنجاح! يمكنك الآن مشاهدة الدروس.');
            }

            // إذا كان مدفوع، ننتظر الدفع
            return redirect()
                ->route('enrollments.payment', $enrollment->id)
                ->with('info', 'يرجى إتمام عملية الدفع لتفعيل الكورس');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * عرض صفحة الدفع
     */
    public function payment(int $enrollmentId): View
    {
        $enrollment = \App\Models\Enrollment::with('course')
            ->where('user_id', auth()->id())
            ->findOrFail($enrollmentId);

        return view('enrollments.payment', compact('enrollment'));
    }

    /**
     * عرض صفحة تقدم المستخدم
     */
    public function myCourses(): View
    {
        $enrollments = $this->enrollmentService->getUserActiveCourses(auth()->id());
        
        return view('enrollments.my-courses', compact('enrollments'));
    }

    /**
     * عرض صفحة تقدم كورس معين
     */
    public function progress(int $courseId): View
    {
        $course = $this->courseService->getCourseById($courseId);
        
        // التحقق من أن المستخدم مسجل في الكورس
        if (!$this->enrollmentService->isUserEnrolled(auth()->id(), $courseId)) {
            return redirect()
                ->route('courses.show', $courseId)
                ->with('error', 'أنت غير مسجل في هذا الكورس');
        }

        $progressPercentage = $this->enrollmentService->getProgressPercentage(auth()->id(), $courseId);
        $completedLessonsIds = $this->enrollmentService->getCompletedLessonsIds(auth()->id(), $courseId);
        $lessons = $course->lessons;

        return view('enrollments.progress', compact('course', 'progressPercentage', 'completedLessonsIds', 'lessons'));
    }

    /**
     * تسجيل إكمال درس
     */
    public function completeLesson(int $lessonId): RedirectResponse
    {
        try {
            $this->enrollmentService->markLessonCompleted(auth()->id(), $lessonId);
            
            return redirect()
                ->back()
                ->with('success', 'تم إكمال الدرس بنجاح!');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
}