<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\PlacementTestController;
use App\Http\Controllers\EnrollmentController;

// الصفحة الرئيسية - صفحة ترحيبية جذابة
Route::get('/', [HomeController::class, 'index'])->name('welcome');

// Routes الخاصة بالمصادقة
Auth::routes();

// Route الخاصة بالـ Home (التي أنشأها Laravel UI)
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Routes المحمية (تتطلب تسجيل دخول)
Route::middleware(['auth'])->group(function () {
    
    // Routes خاصة بالأدمن فقط
    Route::middleware(['admin'])->group(function () {
        Route::resource('courses', CourseController::class)->except(['index', 'show']);
    });
    
    // Routes للجميع (مسجلين الدخول)
    Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/{id}', [CourseController::class, 'show'])->name('courses.show');
    
    // Routes إضافية
    Route::get('/courses/free', [CourseController::class, 'freeCourses'])->name('courses.free');
    Route::get('/courses/paid', [CourseController::class, 'paidCourses'])->name('courses.paid');
    Route::get('/courses/level/{levelId}', [CourseController::class, 'coursesByLevel'])->name('courses.by-level');
});


// Routes للدروس (داخل مجموعة admin)
Route::prefix('courses/{courseId}/lessons')->group(function () {
    Route::get('/', [LessonController::class, 'index'])->name('courses.lessons.index');
    Route::get('/create', [LessonController::class, 'create'])->name('courses.lessons.create');
    Route::post('/', [LessonController::class, 'store'])->name('courses.lessons.store');
    Route::get('/{lessonId}', [LessonController::class, 'show'])->name('courses.lessons.show');
    Route::get('/{lessonId}/edit', [LessonController::class, 'edit'])->name('courses.lessons.edit');
    Route::put('/{lessonId}', [LessonController::class, 'update'])->name('courses.lessons.update');
    Route::delete('/{lessonId}', [LessonController::class, 'destroy'])->name('courses.lessons.destroy');
});

// Routes لاختبار تحديد المستوى
Route::prefix('placement-test')->group(function () {
    Route::get('/', [PlacementTestController::class, 'index'])->name('placement-test.index');
    Route::get('/start', [PlacementTestController::class, 'start'])->name('placement-test.start');
    Route::post('/submit', [PlacementTestController::class, 'submit'])->name('placement-test.submit');
    Route::get('/result', [PlacementTestController::class, 'result'])->name('placement-test.result');
});


// Routes للتسجيل في الكورسات
Route::prefix('enrollments')->group(function () {
    Route::get('/course/{courseId}', [EnrollmentController::class, 'create'])->name('enrollments.create');
    Route::post('/course/{courseId}', [EnrollmentController::class, 'store'])->name('enrollments.store');
    Route::get('/payment/{enrollmentId}', [EnrollmentController::class, 'payment'])->name('enrollments.payment');
    Route::get('/my-courses', [EnrollmentController::class, 'myCourses'])->name('enrollments.my-courses');
    Route::get('/progress/{courseId}', [EnrollmentController::class, 'progress'])->name('enrollments.progress');
    Route::post('/complete-lesson/{lessonId}', [EnrollmentController::class, 'completeLesson'])->name('enrollments.complete-lesson');
});