<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('user_level_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('score');                 // كم سؤال جاوب صح
            $table->foreignId('level_id')->constrained(); // المستوى الناتج
            $table->timestamp('paid_at')->nullable(); // هل دفع ثمن الاختبار؟
            $table->timestamp('completed_at')->nullable(); // متى أكمله؟
            $table->timestamps();
        });
    }

   
    public function down(): void
    {
        Schema::dropIfExists('user_level_tests');
    }
};
