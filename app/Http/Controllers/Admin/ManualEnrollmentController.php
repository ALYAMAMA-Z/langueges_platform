<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class ManualEnrollmentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * تفعيل كورس لطالب معين (يدوياً)
     */
    public function approve($id)
    {
        $enrollment = Enrollment::findOrFail($id);
        
        $enrollment->update([
            'status' => 'active',
            'paid_at' => now(),
        ]);

        return back()->with('success', "✅ تم تفعيل كورس '{$enrollment->course->title_ar}' للطالب {$enrollment->user->name}");
    }
}