<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('daily_words', function (Blueprint $table) {
            $table->id();
            $table->string('word_en');           // الكلمة بالإنجليزي
            $table->string('word_ar');           // الترجمة بالعربي
            $table->text('definition_en');       // شرح بالإنجليزي
            $table->text('definition_ar');       // شرح بالعربي
            $table->text('example_en');          // مثال بالإنجليزي
            $table->text('example_ar');          // مثال بالعربي
            $table->date('scheduled_for');       // التاريخ المقرر إرسالها فيه
            $table->boolean('is_sent')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_words');
    }
};
