<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lesson extends Model
{
    protected $fillable = [
     'course_id', 'title_en', 'title_ar', 'video_url',
    'file_url', 'order', 'is_free_lesson',
    'is_live', 'live_platform', 'live_join_url', 'live_start_time', 'live_duration'
    ];
    
    protected $casts = [
     'is_free_lesson' => 'boolean',
    'is_live' => 'boolean',
    'live_start_time' => 'datetime',
    'live_duration' => 'integer',  // ✅ هذا السطر مهم
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


public function isLiveNow(): bool
{
    if (!$this->is_live || !$this->live_start_time) {
        return false;
    }
    
    $start = $this->live_start_time;
    // ✅ تحويل live_duration إلى int
    $duration = intval($this->live_duration ?? 60);
    $end = $start->copy()->addMinutes($duration);
    
    return now()->between($start, $end);
}
public function getLiveStatusAttribute(): string
{
    if (!$this->is_live) {
        return 'recorded';
    }
    
    if (!$this->live_start_time) {
        return 'upcoming';
    }
    
    if ($this->isLiveNow()) {
        return 'live_now';
    }
    
    if (now()->lt($this->live_start_time)) {
        return 'upcoming';
    }
    
    return 'ended';
}
}