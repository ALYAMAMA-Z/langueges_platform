<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Level;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * عرض الصفحة الرئيسية (للجميع، حتى غير المسجلين)
     */
    public function index(): View
    {
        // أحدث 6 كورسات
        $latestCourses = Course::with('level')
            ->latest()
            ->take(6)
            ->get();
        
        // جميع المستويات
        $levels = Level::all();
        
        // إحصائيات سريعة
        $stats = [
            'courses_count' => Course::count(),
            'students_count' => 0, // سنعدلها لاحقاً بعد نظام التسجيل
            'certificates_count' => 0, // سنعدلها لاحقاً بعد نظام الشهادات
        ];
        
        return view('welcome', compact('latestCourses', 'levels', 'stats'));
    }
}