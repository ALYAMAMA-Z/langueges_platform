<?php

namespace App\Services;

use App\Models\Certificate;
use App\Models\Enrollment;
use App\Models\User;
use App\Models\Course;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CertificateService
{
    protected EnrollmentService $enrollmentService;

    public function __construct(EnrollmentService $enrollmentService)
    {
        $this->enrollmentService = $enrollmentService;
    }

    /**
     * التحقق مما إذا كان المستخدم يستحق شهادة في كورس معين
     */
    public function deservesCertificate(int $userId, int $courseId): bool
    {
        $progressPercentage = $this->enrollmentService->getProgressPercentage($userId, $courseId);
        
        // يحتاج إلى 100% لإتمام الكورس للحصول على الشهادة
        return $progressPercentage >= 100;
    }

    /**
     * إنشاء شهادة PDF للمستخدم
     */
    public function generateCertificate(int $userId, int $courseId): ?Certificate
    {
        return DB::transaction(function () use ($userId, $courseId) {
            // التحقق من وجود شهادة مسبقاً
            $existingCertificate = Certificate::where('user_id', $userId)
                ->where('course_id', $courseId)
                ->first();
                
            if ($existingCertificate) {
                return $existingCertificate;
            }
            
            // التحقق من استحقاق الشهادة
            if (!$this->deservesCertificate($userId, $courseId)) {
                throw new \Exception('يجب إكمال 100% من الكورس للحصول على الشهادة');
            }
            
            $user = User::findOrFail($userId);
            $course = Course::findOrFail($courseId);
            
            // إنشاء مجلد إذا لم يكن موجوداً
            $folder = 'certificates/' . $userId;
            if (!Storage::disk('public')->exists($folder)) {
                Storage::disk('public')->makeDirectory($folder);
            }
            
            // إنشاء ملف PDF
            $pdf = Pdf::loadView('certificates.certificate', compact('user', 'course'));
            $fileName = 'certificate_' . $userId . '_' . $courseId . '_' . time() . '.pdf';
            $filePath = $folder . '/' . $fileName;
            
            Storage::disk('public')->put($filePath, $pdf->output());
            
            // حفظ الشهادة في قاعدة البيانات
            $certificate = Certificate::create([
                'user_id' => $userId,
                'course_id' => $courseId,
                'file_path' => $filePath,
                'issued_at' => now(),
            ]);
            
            Log::info('تم إنشاء شهادة جديدة', [
                'user_id' => $userId,
                'course_id' => $courseId,
                'certificate_id' => $certificate->id,
            ]);
            
            return $certificate;
        });
    }

    /**
     * جلب جميع شهادات المستخدم
     */
    public function getUserCertificates(int $userId)
    {
        return Certificate::with('course')
            ->where('user_id', $userId)
            ->orderBy('issued_at', 'desc')
            ->get();
    }

    /**
     * جلب شهادة محددة
     */
    public function getCertificate(int $certificateId): Certificate
    {
        return Certificate::with(['user', 'course'])
            ->findOrFail($certificateId);
    }
}