<?php

namespace App\Services;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Progress;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EnrollmentService
{
    /**
     * تسجيل طالب في كورس
     */
    public function enrollUser(int $userId, int $courseId, string $paymentMethod = 'manual'): Enrollment
    {
        return DB::transaction(function () use ($userId, $courseId, $paymentMethod) {
            // التحقق من عدم التسجيل مسبقاً
            $existingEnrollment = Enrollment::where('user_id', $userId)
                ->where('course_id', $courseId)
                ->first();

            if ($existingEnrollment) {
                throw new \Exception('أنت مسجل بالفعل في هذا الكورس');
            }

            $course = Course::findOrFail($courseId);

            // إنشاء التسجيل
            $enrollment = Enrollment::create([
                'user_id' => $userId,
                'course_id' => $courseId,
                'status' => $course->price > 0 ? 'pending' : 'active',
                'payment_method' => $paymentMethod,
                'paid_at' => $course->price > 0 ? null : now(),
            ]);

            Log::info('تم تسجيل طالب في كورس', [
                'user_id' => $userId,
                'course_id' => $courseId,
                'enrollment_id' => $enrollment->id,
            ]);

            return $enrollment;
        });
    }

    /**
     * تأكيد الدفع (للأدمن أو بعد الدفع عبر PayPal)
     */
    public function confirmPayment(int $enrollmentId): Enrollment
    {
        return DB::transaction(function () use ($enrollmentId) {
            $enrollment = Enrollment::findOrFail($enrollmentId);
            
            $enrollment->update([
                'status' => 'active',
                'paid_at' => now(),
            ]);

            Log::info('تم تأكيد دفع كورس', [
                'enrollment_id' => $enrollment->id,
                'user_id' => $enrollment->user_id,
                'course_id' => $enrollment->course_id,
            ]);

            return $enrollment;
        });
    }

    /**
     * فتح كورس للطالب يدوياً (بواسطة الأدمن)
     */
    public function adminOpenCourse(int $enrollmentId): Enrollment
    {
        return DB::transaction(function () use ($enrollmentId) {
            $enrollment = Enrollment::findOrFail($enrollmentId);
            
            $enrollment->update([
                'status' => 'active',
                'paid_at' => now(),
                'opened_by_admin_at' => now(),
            ]);

            Log::info('تم فتح كورس للطالب بواسطة الأدمن', [
                'enrollment_id' => $enrollment->id,
                'user_id' => $enrollment->user_id,
                'course_id' => $enrollment->course_id,
            ]);

            return $enrollment;
        });
    }

    /**
     * جلب جميع تسجيلات المستخدم
     */
    public function getUserEnrollments(int $userId)
    {
        return Enrollment::with('course')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * جلب الكورسات النشطة للمستخدم (المدفوعة والمفعلة)
     */
    public function getUserActiveCourses(int $userId)
    {
        return Enrollment::with('course')
            ->where('user_id', $userId)
            ->where('status', 'active')
            ->get();
    }

    /**
     * التحقق مما إذا كان المستخدم مسجلاً في كورس معين
     */
    public function isUserEnrolled(int $userId, int $courseId): bool
    {
        return Enrollment::where('user_id', $userId)
            ->where('course_id', $courseId)
            ->where('status', 'active')
            ->exists();
    }

    /**
     * تسجيل تقدم الطالب في درس معين
     */
    public function markLessonCompleted(int $userId, int $lessonId): Progress
    {
        return DB::transaction(function () use ($userId, $lessonId) {
            // البحث عن التسجيل النشط للكورس الذي يحتوي على هذا الدرس
            $lesson = \App\Models\Lesson::findOrFail($lessonId);
            
            $enrollment = Enrollment::where('user_id', $userId)
                ->where('course_id', $lesson->course_id)
                ->where('status', 'active')
                ->first();

            if (!$enrollment) {
                throw new \Exception('لا يمكن إكمال الدرس: لم تشترك في هذا الكورس');
            }

            // تسجيل إكمال الدرس
            $progress = Progress::updateOrCreate(
                [
                    'enrollment_id' => $enrollment->id,
                    'lesson_id' => $lessonId,
                ],
                [
                    'is_completed' => true,
                    'completed_at' => now(),
                ]
            );

            Log::info('تم إكمال درس', [
                'user_id' => $userId,
                'lesson_id' => $lessonId,
                'enrollment_id' => $enrollment->id,
            ]);

            return $progress;
        });
    }

    /**
     * حساب نسبة تقدم الطالب في كورس معين
     */
    public function getProgressPercentage(int $userId, int $courseId): float
    {
        $enrollment = Enrollment::where('user_id', $userId)
            ->where('course_id', $courseId)
            ->where('status', 'active')
            ->first();

        if (!$enrollment) {
            return 0;
        }

        return $enrollment->completionPercentage();
    }

    /**
     * جلب الدروس المكتملة للمستخدم في كورس معين
     */
    public function getCompletedLessonsIds(int $userId, int $courseId): array
    {
        $enrollment = Enrollment::where('user_id', $userId)
            ->where('course_id', $courseId)
            ->where('status', 'active')
            ->first();

        if (!$enrollment) {
            return [];
        }

        return $enrollment->progress()
            ->where('is_completed', true)
            ->pluck('lesson_id')
            ->toArray();
    }

    /**
 * جلب تسجيل معين بواسطة ID
 */
public function getEnrollmentById(int $enrollmentId): Enrollment
{
    return Enrollment::with('course')->findOrFail($enrollmentId);
}
}