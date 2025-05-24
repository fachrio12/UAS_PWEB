<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAssessmentSession extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'assessment_id',
    ];
    
    protected $casts = [
        'taken_at' => 'datetime',
    ];
    
    // Use taken_at as created_at
    const CREATED_AT = 'taken_at';
    const UPDATED_AT = null;
    
    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    // Relationship with Assessment
    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }
    
    // Relationship with UserAnswers
    public function answers()
    {
        return $this->hasMany(UserAnswer::class, 'session_id');
    }
    
    // Relationship with AssessmentResults
    public function results()
    {
        return $this->hasMany(AssessmentResult::class, 'session_id');
    }
    
    // Relationship with MotivationFactors
    public function motivationFactors()
    {
        return $this->hasMany(MotivationFactor::class, 'session_id');
    }
    
    // Relationship with Feedback
    public function feedback()
    {
        return $this->hasMany(Feedback::class, 'session_id');
    }
}