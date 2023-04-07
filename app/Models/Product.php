<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\ProductAttachment;
use App\Models\ProductItem;

use App\Models\CategoryProduct;
use App\Models\Warehouse;
use App\Models\WarehouseProduct;
use App\Models\Checkout;
use App\Models\ProductSold;


class Product extends Model
{
    protected $table="products";
    protected $fillable=[
        'name',
        'description',
        'price',
        'url_qr_code',
    ];

    public function productAttachments(){
        return $this->hasMany(ProductAttachment::class, 'product_id', 'id');
    }

    public function productItems(){
        return $this->hasMany(ProductItem::class, 'product_id', 'id');
    }

    public function categories(){
        return $this->belongsToMany(CategoryProduct::class, 'category_product', 'product_id', 'category_id', 'id', 'id');
    }

    public function warehouses(){
        return $this->belongsToMany(Warehouse::class, 'warehouse_product', 'product_id', 'warehouse_id', 'id', 'id')->withPivot('amount');
    }

    public function warehouseProducts(){
        return $this->hasMany(WarehouseProduct::class, 'product_id','id');
    }

    public function checkouts(){
        return $this->belongsToMany(Checkout::class, 'checkout_product', 'product_id', 'checkout_id', 'id', 'id')->withPivot('amount', 'price_after_promotion');
    }

    public function totalAmountInCheckout()
    {
        return $this->belongsToMany(Checkout::class, 'checkout_product', 'product_id', 'checkout_id', 'id', 'id')
                    ->wherePivot('product_id', $this->id)
                    ->sum('amount');
    }

    public function productSold(){
        return $this->hasOne(ProductSold::class, 'product_id', 'id');
    }
}
