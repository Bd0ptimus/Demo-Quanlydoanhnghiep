<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use App\Models\User;
class Staff extends Model
{
    protected $table="staffs";
    protected $fillable = [
        'user_id',
        'dob',
        'phone',
        'salary',
        'shift',
        'type_contract',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
