<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ui extends Model
{
    protected $table='ui';
    protected $fillable=[
        'background_url',
        'header_url',
    ];
}
