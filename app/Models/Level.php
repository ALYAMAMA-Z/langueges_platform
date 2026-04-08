<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Level extends Model
{
    protected $fillable = ['name_en', 'name_ar', 'order'];
    
    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }
    
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }
    
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}