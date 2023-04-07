<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Warehouse;

class WarehouseProduct extends Model
{
    protected $table = 'warehouse_product';

    public function product(){
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function warehouse(){
        return $this->belongsTo(Warehouse::class, 'warehouse_id', 'id');

    }
}
