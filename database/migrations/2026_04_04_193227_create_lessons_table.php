<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade'); // تابع لأي كورس
            $table->string('title_en');
            $table->string('title_ar');
            $table->text('video_url')->nullable();      // رابط الفيديو (YouTube أو Vimeo)
            $table->string('file_url')->nullable();     // رابط ملف PDF أو附件
            $table->integer('order')->default(0);       // ترتيب الدرس داخل الكورس
            $table->boolean('is_free_lesson')->default(false); // درس مجاني؟ (أول درس مثلاً)
            $table->timestamps();
        });
    }

 
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
