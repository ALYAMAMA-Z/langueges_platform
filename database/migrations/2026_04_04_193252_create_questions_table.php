<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('level_id')->constrained()->onDelete('cascade'); // السؤال يقيس أي مستوى
            $table->text('question_text_en');
            $table->text('question_text_ar');
            $table->string('option_a_en');
            $table->string('option_a_ar');
            $table->string('option_b_en');
            $table->string('option_b_ar');
            $table->string('option_c_en')->nullable();
            $table->string('option_c_ar')->nullable();
            $table->enum('correct_option', ['a', 'b', 'c']); // الإجابة الصحيحة

            $table->timestamps();
        });
    }

 
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
