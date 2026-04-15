<?php

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\PlacementTestController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\Admin\DailyWordController;
use App\Http\Controllers\Admin\ManualEnrollmentController;
use App\Http\Controllers\PrivacyController;


Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function () {
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

// Routes للدفع
Route::middleware(['auth'])->group(function () {
    Route::get('/payment/process/{enrollmentId}', [PaymentController::class, 'processPayment'])->name('paypal.process');
    Route::get('/payment/success', [PaymentController::class, 'success'])->name('paypal.success');
    Route::get('/payment/cancel', [PaymentController::class, 'cancel'])->name('paypal.cancel');
});



// Routes للشهادات
Route::middleware(['auth'])->group(function () {
    Route::get('/certificates', [CertificateController::class, 'index'])->name('certificates.index');
    Route::get('/certificates/{id}', [CertificateController::class, 'show'])->name('certificates.show');
    Route::post('/certificates/generate/{courseId}', [CertificateController::class, 'generate'])->name('certificates.generate');
    Route::get('/certificates/download/{id}', [CertificateController::class, 'download'])->name('certificates.download');
});



// Routes لإدارة الكلمات اليومية (للأدمن فقط)
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::resource('daily-words', DailyWordController::class);
});
});


// Routes للأدمن فقط
// داخل مجموعة admin routes
Route::put('/enrollments/{id}/approve', [ManualEnrollmentController::class, 'approve'])->name('admin.enrollments.approve');



Route::get('/privacy', [PrivacyController::class, 'index'])->name('privacy');
