<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

//model
use App\Models\Product;
use App\Models\ProductItem;
use App\Models\ProductAttachment;
use App\Models\CategoryProduct;
use App\Models\Warehouse;
use App\Models\WarehouseProduct;


//service
use App\Services\QRCodeService;
use App\Services\AttachmentService;

use Exception;

class ProductService
{
    protected $qrCodeService;
    protected $attachmentService;
    public function __construct(
        QRCodeService $qrCodeService,
        AttachmentService $attachmentService
    ) {
        $this->qrCodeService = $qrCodeService;
        $this->attachmentService = $attachmentService;
    }


    public function takeAllCategories()
    {
        return CategoryProduct::get();
    }
    public function takeAllProducts()
    {
        // return Product::with('productAttachments', 'productItems')->get();
        $products = Product::with(['checkouts', 'productAttachments', 'productSold','productItems', 'warehouseProducts','categories'])->orderBy('updated_at', 'DESC')->get();
        return $products;
    }

    public function addNewProduct($request)
    {
        $warehouses = Warehouse::get();
        $newProduct = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
        ]);
        $newProduct->categories()->sync($request->category);
        $newProductUrl = route('product.index', ['productId' => $newProduct->id]);
        $qrcodeUrl = $this->qrCodeService->generateQRCode($newProductUrl);
        $newProduct->update([
            'url_qr_code'=>$qrcodeUrl,
        ]);
        $warehousesAttach = [];
        foreach ($warehouses as $warehouse) {
            $name = 'warehouse' . $warehouse->id;
            if($request->$name > 0){
                $warehousesAttach[ $warehouse->id] = [
                    'amount'=>$request->$name,
                ];
            }
        }

        $newProduct->warehouses()->attach($warehousesAttach);
        return $newProduct;
    }

    public function updateProduct($request, $productId)
    {
        $product = Product::find($productId);
        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
        ]);
        $product->categories()->sync($request->category);


        $this->attachmentService->removeAttachmentsInStorageByProductId($productId);
        ProductAttachment::where('product_id', $productId)->delete();

        $this->attachmentService->addNewProductAttachment($productId, $request);
    }

    public function resetItems($request, $productId)
    {
        ProductItem::where('product_id', $productId)->delete();
        $warehouses = Warehouse::get();
        // $this->qrCodeService->removeQRCodeInStorageByProductId($productId);
        $product = Product::find($productId);

        $warehousesAttach=[];
        foreach ($warehouses as $warehouse) {
            $name = 'warehouse' . $warehouse->id;
            if($request->$name > 0){
                $warehousesAttach[ $warehouse->id] = [
                    'amount'=>$request->$name,
                ];
            }
        }
        $product->warehouses()->sync($warehousesAttach);


        // foreach ($warehouses as $warehouse) {
        //     $name = 'warehouse' . $warehouse->id;

        //     if ($request->$name > 0) {
        //         foreach (range(1,$request->$name ) as $numItem) {
        //             $newProductItem = ProductItem::create([
        //                 'product_id' => $productId,
        //                 'note' => '',
        //                 'sold' => ITEM_NOT_SOLD,
        //                 'warehouse_id' => $warehouse->id,
        //             ]);
        //             $newProductItemUrl = route('product.item.productItem', ['productItemId' => $newProductItem->id]);
        //             $qrcodeUrl = $this->qrCodeService->generateQRCode($newProductItemUrl);
        //             $newProductItem->update([
        //                 'url_qr_code' => $qrcodeUrl,
        //             ]);
        //         }
        //     }
        // }
    }

    public function increaseItems($request, $productId)
    {
        $warehouses = Warehouse::get();
        $product = Product::find($productId);
        $warehousesAttach = [];
        foreach ($warehouses as $warehouse) {
            $name = 'warehouse' . $warehouse->id;
            if($request->$name > 0){
                $warehouseProduct= WarehouseProduct::where('warehouse_id', $warehouse->id)->where('product_id', $productId)->first();
                if(isset($warehouseProduct)){
                    $amountExisted  =$warehouseProduct->amount;
                    $warehouseProduct->delete();
                }else{
                    $amountExisted =0 ;
                }
                $warehousesAttach[ $warehouse->id] = [
                    'amount'=>intval($request->$name) + intval($amountExisted),
                ];
            }
        }
        // foreach ($warehouses as $warehouse) {
        //     $name = 'warehouse' . $warehouse->id;

        //     if ($request->$name > 0) {
        //         foreach (range(1, $request->$name) as $numItem) {
        //             $newProductItem = ProductItem::create([
        //                 'product_id' => $productId,
        //                 'note' => '',
        //                 'sold' => ITEM_NOT_SOLD,
        //                 'warehouse_id' => $warehouse->id,
        //             ]);
        //             $newProductItemUrl = route('product.item.productItem', ['productItemId' => $newProductItem->id]);
        //             $qrcodeUrl = $this->qrCodeService->generateQRCode($newProductItemUrl);
        //             $newProductItem->update([
        //                 'url_qr_code' => $qrcodeUrl,
        //             ]);
        //             array_push($newProductItems, $newProductItem);
        //         }
        //     }
        // }
        $product->warehouses()->attach($warehousesAttach);

        return $product;
    }

    public function deleteProduct($productId)
    {
        $this->attachmentService->removeAttachmentsInStorageByProductId($productId);
        $this->qrCodeService->removeQRCodeInStorageByProductId($productId);

        Product::find($productId)->delete();
    }

    public function takeProductByItem($itemId)
    {
        return ProductItem::find($itemId)->product;
    }
}
