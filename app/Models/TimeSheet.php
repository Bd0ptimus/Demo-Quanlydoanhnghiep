<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class TimeSheet extends Model
{
    protected $table="timesheet";
    protected $fillable=[
        'user_id',
        'date',
        'start_morning',
        'end_morning',
        'start_afternoon',
        'end_afternoon',
        'start_evening',
        'end_evening',
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id', 'id');
    }
}
