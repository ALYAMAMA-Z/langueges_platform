<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class DailyWord extends Model
{
    protected $fillable = [
        'word_en', 'word_ar', 'definition_en', 'definition_ar',
        'example_en', 'example_ar', 'scheduled_for', 'is_sent'
    ];
    
    protected $casts = [
        'scheduled_for' => 'date',
        'is_sent' => 'boolean',
    ];
    
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'daily_word_user')
            ->withPivot('sent_at')
            ->withTimestamps();
    }
}