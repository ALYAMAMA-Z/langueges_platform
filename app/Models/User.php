<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

  
    protected $fillable = [
        'name',
        'email',
        'password',
        'level_id',  
        'role',       
    ];

   
    protected $hidden = [
        'password',
        'remember_token',
    ];

  
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => 'string', 
        ];
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

public function levelTests(): HasMany
{
    return $this->hasMany(UserLevelTest::class);
}

public function isAdmin(): bool
{
    return $this->role === 'admin';
}

public function enrolledCourses()
{
    return $this->belongsToMany(Course::class, 'enrollments')
        ->wherePivot('status', 'active')
        ->withPivot('paid_at', 'opened_by_admin_at')
        ->withTimestamps();
}

public function completedLessons()
{
    return $this->belongsToMany(Lesson::class, 'progress')
        ->wherePivot('is_completed', true)
        ->withPivot('completed_at');
}


}
