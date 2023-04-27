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
        'atten_image'
    ];
    public function user()
    {
        // return $this->belongsTo('Model', 'foreign_key', 'owner_key'); 
        return $this->belongsTo('App\Models\User','user_id','id');
    }
}
