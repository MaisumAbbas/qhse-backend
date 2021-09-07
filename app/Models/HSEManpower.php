<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class HSEManpower extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'user_id',
        'company_id',
        'set_date',
        'no_manpower'
    ];

    public function getManpower(){
        return $this->hasOne(Manpower::class, 'id', 'company_id');
    }
}
