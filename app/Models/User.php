<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pf',
        'first_name',
        'last_name',
        'position',
        'department_id',
        'phone',
        'email',
        'type',
        'active',
        'password',
        'city',
        'country',
        'about',
        'picture',
        'dob',
        'created_by'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getUser(){
        return $this->belongsTo(UserProject::class, 'user_id', 'pf');
    }

    public function getProjectManager(){
        return $this->hasMany(Project::class, 'assigned_manager', 'pf');
    }
}
