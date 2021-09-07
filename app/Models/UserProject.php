<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class UserProject extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'project_id',
        'user_id'
    ];

    public function getUser(){
        return $this->hasMany(User::class, 'pf', 'user_id');
    }

    public function getProject(){
        return $this->hasMany(Project::class, 'job', 'project_id');
    }
}
