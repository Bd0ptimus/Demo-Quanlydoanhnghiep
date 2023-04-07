<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\ProductItem;
use App\Models\Product;
class Checkout extends Model
{
    protected $table = "checkouts";
    protected $fillable = [
        'staff_id',
        'checkout_code',
        'pay_amount',
        'status',
        'buyer_name',
        'buyer_address',
        'buyer_telephone',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'staff_id', 'id');
    }

    public function productItems()
    {
        return $this->hasMany(ProductItem::class, 'checkout_id', 'id' );
    }

    public function products(){
        return $this->belongsToMany(Product::class, 'checkout_product', 'checkout_id', 'product_id', 'id','id')->withPivot('amount', 'price_after_promotion');
    }
}


