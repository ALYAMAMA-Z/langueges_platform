<?php

namespace App\Http\Controllers;

use App\Services\PaymentService;
use App\Services\EnrollmentService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PaymentController extends Controller
{
    protected PaymentService $paymentService;
    protected EnrollmentService $enrollmentService;

    public function __construct(PaymentService $paymentService, EnrollmentService $enrollmentService)
    {
        $this->paymentService = $paymentService;
        $this->enrollmentService = $enrollmentService;
    }

    /**
     * معالجة الدفع عبر PayPal
     */
    public function processPayment(int $enrollmentId): RedirectResponse
    {
        $enrollment = $this->enrollmentService->getEnrollmentById($enrollmentId);
        
        // التأكد من أن التسجيل يخص المستخدم الحالي
        if ($enrollment->user_id !== auth()->id()) {
            abort(403);
        }

        // إنشاء طلب دفع
        $response = $this->paymentService->createPayment($enrollment);

        if (isset($response['id']) && $response['status'] === 'CREATED') {
            // العثور على رابط الموافقة
            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect()->away($link['href']);
                }
            }
        }

        return redirect()
            ->route('enrollments.payment', $enrollmentId)
            ->with('error', 'حدث خطأ في عملية الدفع. الرجاء المحاولة مرة أخرى.');
    }

    /**
     * صفحة نجاح الدفع
     */
    public function success(Request $request): RedirectResponse
    {
        $token = $request->query('token');
        $payerId = $request->query('PayerID');

        if (!$token || !$payerId) {
            return redirect()
                ->route('courses.index')
                ->with('error', 'بيانات الدفع غير مكتملة');
        }

        $enrollment = $this->paymentService->handleSuccessfulPayment($token, $payerId);

        if ($enrollment) {
            return redirect()
                ->route('enrollments.progress', $enrollment->course_id)
                ->with('success', 'تم الدفع بنجاح! يمكنك الآن مشاهدة الكورس.');
        }

        return redirect()
            ->route('courses.index')
            ->with('error', 'حدث خطأ في تأكيد الدفع. الرجاء التواصل مع الدعم.');
    }

    /**
     * صفحة إلغاء الدفع
     */
    public function cancel(Request $request): RedirectResponse
    {
        return redirect()
            ->route('courses.index')
            ->with('info', 'تم إلغاء عملية الدفع.');
    }
}