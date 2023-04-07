<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Product;
class CategoryProduct extends Model
{
    protected $table="categories";
    protected $fillable=[
        'category_name',
        'description',
    ];

    public function products(){
        return $this->belongsToMany(Product::class, 'category_product', 'category_id', 'product_id', 'id', 'id');
    }

}
