<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lesson extends Model
{
    protected $fillable = [
        'course_id', 'title_en', 'title_ar', 'video_url',
        'file_url', 'order', 'is_free_lesson'
    ];
    
    protected $casts = [
        'is_free_lesson' => 'boolean',
    ];
    
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
    
    public function progress(): HasMany
    {
        return $this->hasMany(Progress::class);
    }
    
    public function isCompletedByUser($userId): bool
    {
        return $this->progress()
            ->whereHas('enrollment', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->where('is_completed', true)
            ->exists();
    }
}