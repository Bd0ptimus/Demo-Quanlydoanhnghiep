<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use App\Models\DiscountProductProgram;
use App\Models\ProductItem;

class PromotionProgram extends Model
{
    protected $table="promotion_programs";
    protected $fillable=[
        'name',
        'program_code',
        'start_date',
        'end_date',
        'program_type',
    ];

    public function discountProductPrograms(){
        return $this->hasMany(DiscountProductProgram::class, 'program_id', 'id');
    }

    public function productItem(){
        return $this->belongsTo(ProductItem::class, 'promotion_program_id', 'id');
    }


}
