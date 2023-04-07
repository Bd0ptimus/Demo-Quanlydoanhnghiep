<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Product;
use App\Models\PromotionProgram;
class DiscountProductProgram extends Model
{
    protected $table="discount_product_programs";
    protected $fillable=[
        'program_id',
        'product_id',
        'new_price',
    ];

    public function product(){
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function promotionProgram(){
        return $this->belongsTo(PromotionProgram::class, 'program_id', 'id');
    }
}
