<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'job',
        'title',
        'location',
        'department_id',
        'client',
        'assigned_manager',
        'active',
        'user_id'
    ];

    public function getProjectRemark(){
        return $this->hasMany(ProjectRemark::class, 'project_id', 'job');
    }

    public function getProjectManager(){
        return $this->hasOne(User::class, 'pf', 'assigned_manager');
    }

    public function getProject(){
        return $this->belongsTo(UserProject::class, 'project_id', 'job');
    }
}
