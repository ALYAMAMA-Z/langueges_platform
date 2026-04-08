<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserLevelTest extends Model
{
    protected $fillable = [
        'user_id', 'score', 'level_id', 'paid_at', 'completed_at'
    ];
    
    protected $casts = [
        'paid_at' => 'datetime',
        'completed_at' => 'datetime',
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }
}