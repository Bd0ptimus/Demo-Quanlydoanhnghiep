<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Admin;

use App\Models\TimeSheet;
use App\Models\Staff;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'password_raw',
        'position_title',
        'pid',
        'roles',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isRole($role=''){
        return Admin::user()->roles == $role;
    }

    public function inRoles($roles=[]){
        return in_array(Admin::user()->roles, $roles);
    }

    public function staff(){
        return $this->hasOne(Staff::class, 'user_id', 'id');
    }

    public function timesheets(){
        return $this->hasMany(TimeSheet::class, 'user_id','id');
    }
}
