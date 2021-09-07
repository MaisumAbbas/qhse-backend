<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Manpower extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'project_id',
        'company',
        'type',
        'user_id'
    ];
    

    public function getManpower(){
        return $this->hasMany(HSEManpower::class, 'company_id', 'id');
    }
}
