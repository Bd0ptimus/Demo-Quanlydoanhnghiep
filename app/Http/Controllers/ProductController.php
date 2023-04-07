<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ProductItem;
use App\Models\Product;

use App\Services\ProductService;
class ProductController extends Controller
{
    protected $productService;
    public function __construct(ProductService $productService){
        $this->productService = $productService;

    }
    public function productItem(Request $request, $productItemId){
        // dd(ProductItem::find($productItemId));
        $product = $this->productService->takeProductByItem($productItemId);
        $amountItemInStock = $product->productItems->where('sold', ITEM_NOT_SOLD)->count();
        return view('product.index',[
            'product' => $product,
            'amountItemInStock' => $amountItemInStock,
        ]);
    }

    public function index(Request $request, $productId){
        $product = Product::find($productId);
        $amountItemInStock = $product->productItems->where('sold', ITEM_NOT_SOLD)->count();
        return view('product.index',[
            'product' => $product,
            'amountItemInStock' => $amountItemInStock,
        ]);

    }
}
