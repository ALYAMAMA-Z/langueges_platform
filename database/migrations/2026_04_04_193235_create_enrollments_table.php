<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['pending', 'active', 'cancelled'])->default('pending'); // حالة الدفع
            $table->string('payment_method')->nullable(); // PayPal أو manual
            $table->timestamp('paid_at')->nullable();     // متى دفع؟
            $table->timestamp('opened_by_admin_at')->nullable(); // لو فتحه الأدمن يدويًا
            $table->timestamps();

                        
            // منع التسجيل المكرر لنفس الكورس لنفس المستخدم
            $table->unique(['user_id', 'course_id']);

        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
