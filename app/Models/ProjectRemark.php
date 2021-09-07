<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ProjectRemark extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'code',
        'remarks',
        'project_id'
    ];

    public function getProjectRemark(){
        return $this->belongsTo(Project::class, 'job', 'project_id');
    }
}
