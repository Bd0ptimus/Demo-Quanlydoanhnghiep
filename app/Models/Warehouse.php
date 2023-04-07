<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\ProductItem;
use App\Models\Product;
use App\Models\WarehouseProduct;

class Warehouse extends Model
{
    protected $table = "warehouses";
    protected $fillable = [
        'name',
        'address'
    ];

    public function productItems(){
        return $this->hasMany(ProductItem::class,'warehouse_id', 'id');
    }

    public function products(){
        return $this->belongsToMany(Product::class, 'warehouse_product', 'warehouse_id', 'product_id', 'id', 'id')->withPivot('amount');
    }

    public function warehouseProducts(){
        return $this->hasMany(WarehouseProduct::class, 'warehouse_id','id');
    }

}
