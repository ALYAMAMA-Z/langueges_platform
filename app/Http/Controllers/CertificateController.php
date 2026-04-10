<?php

namespace App\Http\Controllers;

use App\Services\CertificateService;
use App\Services\EnrollmentService;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CertificateController extends Controller
{
    protected CertificateService $certificateService;
    protected EnrollmentService $enrollmentService;

    public function __construct(CertificateService $certificateService, EnrollmentService $enrollmentService)
    {
        $this->certificateService = $certificateService;
        $this->enrollmentService = $enrollmentService;
    }

    /**
     * عرض جميع شهادات المستخدم
     */
    public function index(): View
    {
        $certificates = $this->certificateService->getUserCertificates(auth()->id());
        return view('certificates.index', compact('certificates'));
    }

    /**
     * عرض شهادة محددة
     */
    public function show(int $certificateId): View
    {
        $certificate = $this->certificateService->getCertificate($certificateId);
        
        // التأكد من أن الشهادة تخص المستخدم الحالي
        if ($certificate->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }
        
        return view('certificates.show', compact('certificate'));
    }

    /**
     * إنشاء شهادة جديدة لكورس معين
     */
    public function generate(int $courseId): RedirectResponse
    {
        try {
            // التحقق من أن المستخدم أكمل الكورس
            if (!$this->certificateService->deservesCertificate(auth()->id(), $courseId)) {
                return redirect()
                    ->route('enrollments.progress', $courseId)
                    ->with('error', 'يجب إكمال جميع دروس الكورس أولاً للحصول على الشهادة');
            }
            
            $certificate = $this->certificateService->generateCertificate(auth()->id(), $courseId);
            
            return redirect()
                ->route('certificates.show', $certificate->id)
                ->with('success', 'تهانينا! تم إنشاء شهادتك بنجاح 🎉');
                
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * تنزيل شهادة PDF
     */
    public function download(int $certificateId)
    {
        $certificate = $this->certificateService->getCertificate($certificateId);
        
        if ($certificate->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }
        
        $filePath = storage_path('app/public/' . $certificate->file_path);
        
        if (!file_exists($filePath)) {
            abort(404, 'ملف الشهادة غير موجود');
        }
        
        return response()->download($filePath, basename($filePath));
    }
}