<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = [
        'attendance_id',
        'user_id',
        'punch_type',
        'photo_name',
        'lat',
        'long',
        'place',
    ];

    public function attendance()
    {
        // return $this->belongsTo('Model', 'foreign_key', 'owner_key'); 
        return $this->belongsTo('App\Models\Attendance','attendance_id','id');
    }
    
}
