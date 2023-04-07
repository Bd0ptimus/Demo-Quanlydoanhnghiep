<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\CostType;
class Cost extends Model
{
    protected $table= "costs";
    protected $fillable=[
        'note',
        'cost',
        'date_pay',
        'cost_type',
    ];

    public function costType(){
        return $this->belongsTo(CostType::class, 'cost_type','id');
    }
}
