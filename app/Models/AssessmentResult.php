<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentResult extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'session_id',
        'result_category',
        'score',
        'interpretation',
    ];
    
    public $timestamps = false;
    
    // Relationship with UserAssessmentSession
    public function session()
    {
        return $this->belongsTo(UserAssessmentSession::class, 'session_id');
    }
}