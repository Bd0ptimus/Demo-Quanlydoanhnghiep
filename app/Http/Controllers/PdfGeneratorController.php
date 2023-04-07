<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

use App\Models\Product;
use App\Models\WarehouseProduct;

class PdfGeneratorController extends Controller
{
    public function index(Request $request, $productId)
    {
        $product = Product::with(['warehouses'])->where('id', $productId)->first();
        // dd($product->warehouses);
        return view('admin.product.qrSheetRender',[
            'product'=>$product,
        ]);
        // $pdf = PDF::loadView('admin.product.qrSheetRender', $data);
        // return $pdf->stream('qrSheetRender.pdf');
    }
}
