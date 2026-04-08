<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title_en');           // عنوان الكورس بالإنجليزي
            $table->string('title_ar');           // عنوان الكورس بالعربي
            $table->text('description_en');       // وصف بالإنجليزي
            $table->text('description_ar');       // وصف بالعربي
            $table->decimal('price', 10, 2);      // السعر (مثال: 99.99)
            $table->string('image')->nullable();  // صورة الغلاف
            $table->foreignId('level_id')->nullable()->constrained()->onDelete('set null'); // المستوى المناسب
            $table->boolean('is_live')->default(false); // هل فيه دروس مباشرة؟
            $table->timestamps();
        });
    }

   
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
