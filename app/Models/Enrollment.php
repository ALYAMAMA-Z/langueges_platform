<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Enrollment extends Model
{
    protected $fillable = [
        'user_id', 'course_id', 'status', 'payment_method',
        'paid_at', 'opened_by_admin_at'
              
    ];
    
    protected $casts = [
        'paid_at' => 'datetime',
        'opened_by_admin_at' => 'datetime',
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
    
    public function progress(): HasMany
    {
        return $this->hasMany(Progress::class);
    }
    
    public function completedLessonsCount(): int
    {
        return $this->progress()
            ->where('is_completed', true)
            ->count();
    }
    
    public function completionPercentage(): float
    {
        $totalLessons = $this->course->lessons()->count();
        if ($totalLessons === 0) return 0;
        
        return ($this->completedLessonsCount() / $totalLessons) * 100;
    }
    
    public function isCompleted(): bool
    {
        return $this->completionPercentage() >= 100;
    }
}