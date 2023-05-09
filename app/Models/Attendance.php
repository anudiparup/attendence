<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'atten_date',
        'punch_in',
        'punch_out',
        'lat',
        'long',
        'member_id',
        'member_code',
        'member_type',
        'transfer_status',
        'atten_type',
        'status',
        'atten_image',
        'punch_in_place',
        'punch_out_place',
        'punch_out_lat',
        'punch_out_long',
        'reason',
    ];
    public function user()
    {
        // return $this->belongsTo('Model', 'foreign_key', 'owner_key'); 
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    public function photo()
    {
        return $this->hasMany('App\Models\Photo');
    }
}
