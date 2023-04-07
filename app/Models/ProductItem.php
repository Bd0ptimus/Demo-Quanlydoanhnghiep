<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Product;
use App\Models\Checkout;
use App\Models\PromotionProgram;
use App\Models\Warehouse;
class ProductItem extends Model
{
    protected $table="product_items";
    protected $fillable=[
        'product_id',
        'note',
        'sold',
        'checkout_id',
        'url_qr_code',
        'promotion_program_id',
        'warehouse_id'
    ];

    public function product(){
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function checkouts(){
        return $this->belongsTo(Checkout::class, 'checkout_id', 'id');
    }

    public function promotionProgram(){
        return $this->hasOne(PromotionProgram::class,'promotion_program_id', 'id');
    }

    public function warehouse(){
        return $this->belongsTo(Warehouse::class, 'warehouse_id', 'id');
    }

}
