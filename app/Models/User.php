<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password_hash',
        'birth_date',
        'gender',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password_hash',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'birth_date' => 'date',
    ];
    
    // Password accessor and mutator
    public function getAuthPassword()
    {
        return $this->password_hash;
    }
    
    public function setPasswordAttribute($value)
    {
        $this->attributes['password_hash'] = $value;
    }
    
    // Relationship with Role
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    
    // Relationship with UserAssessmentSessions
    public function sessions()
    {
        return $this->hasMany(UserAssessmentSession::class);
    }
    
    // Check if user is admin
    public function isAdmin()
    {
        return $this->role_id === 1;
    }
}