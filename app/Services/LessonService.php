<?php

namespace App\Services;

use App\Models\Lesson;
use App\Models\Course;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LessonService
{
    /**
     * جلب جميع الدروس لكورس معين
     */
    public function getLessonsByCourse(int $courseId): Collection
    {
        return Lesson::where('course_id', $courseId)
            ->orderBy('order')
            ->get();
    }

    /**
     * جلب درس محدد
     */
    public function getLessonById(int $lessonId): ?Lesson
    {
        return Lesson::with('course')->findOrFail($lessonId);
    }

    /**
     * إنشاء درس جديد
     */
    public function createLesson(array $data): Lesson
    {
        return DB::transaction(function () use ($data) {
            $lesson = Lesson::create([
                'course_id' => $data['course_id'],
                'title_en' => $data['title_en'],
                'title_ar' => $data['title_ar'],
                'video_url' => $data['video_url'] ?? null,
                'file_url' => $data['file_url'] ?? null,
                'order' => $data['order'] ?? 0,
                'is_free_lesson' => $data['is_free_lesson'] ?? false,
            ]);

            Log::info('تم إنشاء درس جديد', [
                'lesson_id' => $lesson->id,
                'title' => $lesson->title_ar,
                'course_id' => $data['course_id'],
            ]);

            return $lesson;
        });
    }

    /**
     * تحديث درس
     */
    public function updateLesson(int $lessonId, array $data): Lesson
    {
        return DB::transaction(function () use ($lessonId, $data) {
            $lesson = Lesson::findOrFail($lessonId);
            $lesson->update($data);

            Log::info('تم تحديث درس', [
                'lesson_id' => $lesson->id,
                'title' => $lesson->title_ar,
            ]);

            return $lesson;
        });
    }

    /**
     * حذف درس
     */
    public function deleteLesson(int $lessonId): bool
    {
        return DB::transaction(function () use ($lessonId) {
            $lesson = Lesson::findOrFail($lessonId);
            
            Log::warning('تم حذف درس', [
                'lesson_id' => $lesson->id,
                'title' => $lesson->title_ar,
            ]);
            
            return $lesson->delete();
        });
    }

    /**
     * ترتيب الدروس (سحب وإفلات)
     */
    public function reorderLessons(int $courseId, array $orderedIds): void
    {
        foreach ($orderedIds as $index => $lessonId) {
            Lesson::where('id', $lessonId)
                ->where('course_id', $courseId)
                ->update(['order' => $index + 1]);
        }
        
        Log::info('تم إعادة ترتيب الدروس', [
            'course_id' => $courseId,
            'lessons_count' => count($orderedIds),
        ]);
    }
}