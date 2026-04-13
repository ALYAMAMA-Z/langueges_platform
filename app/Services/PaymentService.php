<?php

namespace App\Services;

use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\Enrollment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    protected PayPalClient $provider;
    protected EnrollmentService $enrollmentService;

 public function __construct(EnrollmentService $enrollmentService)
{
    $this->enrollmentService = $enrollmentService;
    $this->provider = new PayPalClient;
    $this->provider->setApiCredentials(config('paypal'));
    
    $token = $this->provider->getAccessToken();
    \Illuminate\Support\Facades\Log::info('PayPal Access Token', ['token' => $token]);
}

    /**
     * إنشاء طلب دفع جديد
     */
  public function createPayment(Enrollment $enrollment): array
{
    $course = $enrollment->course;
    
    $response = $this->provider->createOrder([
        "intent" => "CAPTURE",
        "purchase_units" => [
            [
                "reference_id" => (string) $enrollment->id,
                "description" => "Course: " . $course->title_en,
                "amount" => [
                    "currency_code" => config('paypal.currency', 'USD'),
                    "value" => (string) $course->price,
                ]
            ]
        ],
        "application_context" => [
            "return_url" => route('paypal.success'),
            "cancel_url" => route('paypal.cancel'),
            "brand_name" => "Language Learning Platform",
            "user_action" => "PAY_NOW",
        ]
    ]);

    Log::info('PayPal order created', [
        'enrollment_id' => $enrollment->id,
        'order_id' => $response['id'] ?? null,
        'status' => $response['status'] ?? null,
        'full_response' => $response
    ]);

    return $response;
}

    /**
     * استكمال الدفع بعد موافقة المستخدم
     */
  public function capturePayment(string $token, string $payerId): array
{
    $response = $this->provider->capturePaymentOrder($token);

    Log::info('PayPal payment captured', [
        'token' => $token,
        'payer_id' => $payerId,
        'status' => $response['status'] ?? null,
        'full_response' => $response
    ]);
    
    return $response;
}
    /**
     * معالجة الدفع الناجح وتفعيل الكورس
     */
    public function handleSuccessfulPayment(string $token, string $payerId): ?Enrollment
    {
        $response = $this->capturePayment($token, $payerId);

        if (isset($response['status']) && $response['status'] === 'COMPLETED') {
            // استخراج enrollment_id من purchase_units
            $enrollmentId = $response['purchase_units'][0]['reference_id'] ?? null;
            
            if ($enrollmentId) {
                // تفعيل التسجيل
                $enrollment = $this->enrollmentService->confirmPayment($enrollmentId);
                
                Log::info('Course activated after successful payment', [
                    'enrollment_id' => $enrollmentId,
                    'user_id' => $enrollment->user_id,
                    'course_id' => $enrollment->course_id,
                ]);
                
                return $enrollment;
            }
        }

        return null;
    }
}