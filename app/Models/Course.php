<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Course extends Model
{
    protected $fillable = [
        'title_en', 'title_ar', 'description_en', 'description_ar',
        'price', 'image', 'level_id', 'is_live'
    ];
    
    protected $casts = [
        'price' => 'decimal:2',
        'is_live' => 'boolean',
    ];
    
    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class)->orderBy('order');
    }
    
    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }
    
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }
    
    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }
    
    public function freeLesson(): ?Lesson
    {
        return $this->lessons()->where('is_free_lesson', true)->first();
    }
    
    public function isUserEnrolled($userId): bool
    {
        return $this->enrollments()
            ->where('user_id', $userId)
            ->where('status', 'active')
            ->exists();
    }
}