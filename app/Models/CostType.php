<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cost;
class CostType extends Model
{
    protected $table="costs_type";
    protected $fillable=[
        'name',
        'cost_type',
    ];

    public function costs(){
        return $this->hasMany(Cost::class, 'cost_type', 'id');
    }
}
