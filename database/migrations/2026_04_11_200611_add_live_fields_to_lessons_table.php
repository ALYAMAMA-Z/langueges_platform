<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->boolean('is_live')->default(false)->after('is_free_lesson');
            $table->string('live_platform')->nullable()->after('is_live');
            $table->string('live_join_url')->nullable()->after('live_platform');
            $table->datetime('live_start_time')->nullable()->after('live_join_url');
            $table->string('live_duration')->nullable()->after('live_start_time');
        });
    }

    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropColumn(['is_live', 'live_platform', 'live_join_url', 'live_start_time', 'live_duration']);
        });
    }
};