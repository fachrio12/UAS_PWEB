<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'description',
        'is_active'
    ];
    
    protected $casts = [
        'is_active' => 'boolean',
    ];
    
    public $timestamps = false;
    
    // Relationship with Questions
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
    
    // Relationship with UserAssessmentSessions
    public function sessions()
    {
        return $this->hasMany(UserAssessmentSession::class);
    }
}