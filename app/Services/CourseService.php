<?php

namespace App\Services;

use App\Models\Course;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CourseService
{
    /**
     * all courses
     */
    public function getAllCourses(): Collection
    {
        return Course::with(['level', 'lessons'])->get();
    }

    /**
     * course with detials
     */
    public function getCourseById(int $courseId): ?Course
    {
        return Course::with(['level', 'lessons', 'enrollments'])
            ->findOrFail($courseId);
    }

    /**
     * creating new course
     */
    public function createCourse(array $data): Course
    {
        return DB::transaction(function () use ($data) {
            $course = Course::create([
                'title_en' => $data['title_en'],
                'title_ar' => $data['title_ar'],
                'description_en' => $data['description_en'],
                'description_ar' => $data['description_ar'],
                'price' => $data['price'],
                'image' => $data['image'] ?? null,
                'level_id' => $data['level_id'] ?? null,
                'is_live' => $data['is_live'] ?? false,
            ]);

            Log::info('تم إنشاء كورس جديد', [
                'course_id' => $course->id,
                'title' => $course->title_en,
            ]);

            return $course;
        });
    }

    /**
     * update course
     */
    public function updateCourse(int $courseId, array $data): Course
    {
        return DB::transaction(function () use ($courseId, $data) {
            $course = Course::findOrFail($courseId);
            
            $course->update($data);

            Log::info('تم تحديث كورس', [
                'course_id' => $course->id,
                'title' => $course->title_en,
            ]);

            return $course;
        });
    }

    /**
     * delete course
     */
    public function deleteCourse(int $courseId): bool
    {
        return DB::transaction(function () use ($courseId) {
            $course = Course::findOrFail($courseId);
            
            Log::warning('تم حذف كورس', [
                'course_id' => $course->id,
                'title' => $course->title_en,
            ]);
            
            return $course->delete();
        });
    }

    /**
     * free courses
     */
    public function getFreeCourses(): Collection
    {
        return Course::where('price', 0)->get();
    }

    /**
     * paid courses
     */
    public function getPaidCourses(): Collection
    {
        return Course::where('price', '>', 0)->get();
    }

    /**
     *courses depending on the level
     */
    public function getCoursesByLevel(int $levelId): Collection
    {
        return Course::where('level_id', $levelId)->get();
    }
}