<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Str;
use Carbon\Carbon;
use DateTime;

//model
use App\Models\Checkout;
use App\Models\ProductItem;
use App\Models\DiscountProductProgram;
use App\Models\PromotionProgram;
use App\Models\Warehouse;

//service
use App\Services\UtilService;

use App\Admin;
use App\Models\ProductSold;
use Exception;
class InvoiceService
{

    public function takeAllInvoice(){
        return Checkout::get();
    }

    public function takeInvoiceDependOnStatus($status){
        if($status == -1){
            return Checkout::with('user')->get();

        }
        return Checkout::with('user')->where('status', $status)->get();

    }

    public function takeAllCompletedInvoiceOrderByDateCreated(){
        return Checkout::where('status' , CHECKOUT_DONE)->orderBy('created_at', 'DESC')->get();
    }
    public function takeTotalIncome(){
        $totalIncome = Checkout::where('status', CHECKOUT_DONE)->sum('pay_amount');
        return $totalIncome;
    }
    public function newInvoice(){
        $newCheckout = Checkout::create([
            'staff_id' => Admin::user()->id,
            'status' => CHECKOUT_PENDING,
        ]);

        $newCheckout->update([
            'checkout_code' => $newCheckout->id,
        ]);

        return $newCheckout;
    }

    public function addItem($request){
        $item = ProductItem::where('sold', ITEM_NOT_SOLD)->where('id', $request->itemId)->first();
        if(!isset($item)){
            return null;
        }
        $item ->update([
            'sold'=> ITEM_IN_INVOICE,
            'checkout_id' => $request->checkoutId,
        ]);



        return Checkout::with('productItems')->find($request->checkoutId);
    }

    public function removeItemFromInvoice($request){
        $item = ProductItem::where('sold', ITEM_IN_INVOICE)->where('id', $request->itemId)->where('checkout_id', $request->checkoutId)->first();
        if(!isset($item)){
            return null;
        }

        $item ->update([
            'sold'=> ITEM_NOT_SOLD,
            'checkout_id' => null,
            'promotion_program_id' => null,
        ]);

        return Checkout::with('productItems')->find($request->checkoutId);

    }


    public function exportInvoice($request){
        DB::beginTransaction();
        try {
            $newCheckout = Checkout::create([
                'staff_id' => Admin::user()->id,
                'pay_amount' => $request['totalPay'],
                'status' => CHECKOUT_DONE,
                'buyer_name' => $request['buyerName'] ?? null,
                'buyer_address' => $request['buyerAddress'] ?? null,
                'buyer_telephone' => $request['buyerPhone'] ?? null,
            ]);
            // foreach ($request['invoiceData'] as $invoiceData) {
            //     CheckoutDetail::create([
            //         'checkout_id' => $newCheckout->id,
            //         'product_id' => $invoiceData['id'],
            //         'amount' =>  $invoiceData['amount'],
            //     ]);
            // }

            $checkoutProduct = [];
            $warehouseId = $request->warehouseId;
            foreach($request['invoiceData'] as $invoiceData){
                $productId = intval($invoiceData['productId']);
                $amountProductInvoice = $invoiceData['amount'];
                $warehouseExisting =  Warehouse::where('id', $warehouseId)->with('products', function ($query) use ($productId){
                    $query->where('product_id', $productId)->wherePivot('amount', '>', 0);
                })->first();
                $amountProductInWarehouse = $warehouseExisting->products->first()->pivot->amount;
                $amountLeft =  $amountProductInWarehouse - $amountProductInvoice;
                $warehouseExisting->products()->updateExistingPivot($productId,['amount' => $amountLeft]);
                $checkoutProduct[$productId] = [
                    'amount' => $amountProductInvoice,
                    'price_after_promotion' => $invoiceData['priceAfterPromotion'],
                ];

                $productSold = ProductSold::where('product_id', $productId)->first();
                if(isset($productSold)){
                    $productSold->create([
                        'amount_sold' => $productSold->amount + $amountProductInvoice,
                    ]);
                }else{
                    ProductSold :: create([
                        'product_id' => $productId,
                        'amount_sold' => $amountProductInvoice,
                    ]);
                }
            }
            $newCheckout->products()->attach($checkoutProduct);
            DB::commit();
            $response['complete'] = 1;
            $response['newCheckoutId'] = $newCheckout->id;
        } catch (\Exception $e) {
            Log::debug('error in export product : ' . $e);
            DB::rollBack();
            $response['complete'] = 0;
        }
        return $response;
    }

    public function exportInvoiceOld($request, $invoiceId){
        $invoiceArr = [];
        DB::beginTransaction();
        try {
            $checkoutComplete = Checkout::with('productItems')->where('id',$invoiceId)->first();
            $checkoutComplete->update([
                'status'=>CHECKOUT_DONE,
                'buyer_name'=>$request->buyerName,
                'buyer_address'=>$request->buyerAddress,
                'buyer_telephone' => $request->buyerPhone,
            ]);
            $productInfos=[];
            $response['sumToPay'] = $this->calculateSumInvoice($invoiceId);
            foreach($checkoutComplete->productItems as $item){
                $item->update([
                    'sold'=>ITEM_SOLD,
                ]);
                // $response['sumToPay'] = $response['sumToPay']+$item->product->price;

                if(isset($productInfos[$item->product_id]['number']) && $productInfos[$item->product_id]['number'] > 0){
                    $productInfos[$item->product_id]['number']=$productInfos[$item->product_id]['number']+1;
                    // $productInfos[$item->product_id]['sumPrice'] = $productInfos[$item->product_id]['sumPrice'] + $item->product->price;
                    if(isset($item->promotion_program_id)){
                        $promotionProgram = PromotionProgram::find($item->promotion_program_id);
                        if($promotionProgram->program_type == DISCOUNT_PRODUCT){
                            $discountProductProgram =DiscountProductProgram::where('program_id',$promotionProgram->id)->where('product_id', $item->product->id)->first();
                            $productInfos[$item->product_id]['sumPrice']=$productInfos[$item->product_id]['sumPrice'] + $discountProductProgram->new_price;
                        }
                    }
                }else{
                    $productInfos[$item->product_id]['number'] = 1;
                    // $productInfos[$item->product_id]['sumPrice'] = $item->product->price;
                    // $productInfos[$item->product_id]['singlePrice'] =  $item->product->price;
                    $productInfos[$item->product_id]['name'] = $item->product->name;
                    $productInfos[$item->product_id]['productId'] = $item->product->id;

                    if(isset($item->promotion_program_id)){
                        $promotionProgram = PromotionProgram::find($item->promotion_program_id);
                        if($promotionProgram->program_type == DISCOUNT_PRODUCT){
                            $discountProductProgram =DiscountProductProgram::where('program_id',$promotionProgram->id)->where('product_id', $item->product->id)->first();
                            $productInfos[$item->product_id]['singlePrice']=$discountProductProgram->new_price;
                        }
                    }
                    $productInfos[$item->product_id]['sumPrice'] = $productInfos[$item->product_id]['singlePrice'];


                }
            }

            foreach($productInfos as $productInfo){
                if(isset($productInfo['number'])&&$productInfo['number']>0){
                    array_push($invoiceArr, $productInfo);
                }
            }
            $checkoutComplete ->update([
                'pay_amount' => $response['sumToPay'],
            ]);
            DB::commit();
            $response['checkoutData'] = $checkoutComplete;

        } catch (\Exception $e) {
            Log::debug('error in add product : ' . $e);
            DB::rollBack();
            $invoiceArr = [];
        }
        $response['itemData'] = $invoiceArr;

        return $response;
    }

    public function showInvoice($invoiceId){
        $invoiceArr = [];
        $checkoutComplete = Checkout::with('productItems')->where('id',$invoiceId)->first();
        $response['sumToPay'] =  $checkoutComplete->pay_amount??0;
        $productInfos=[];
        if(isset($checkoutComplete)){
            foreach($checkoutComplete->products as $product){
                $amount = $product->pivot->amount;
                $price =  $product->pivot->price_after_promotion;
                $productId =$product->id;
                $productInfos[$productId]['number'] =$amount ;
                $productInfos[$productId ]['sumPrice'] =$price * $amount;
                $productInfos[$productId ]['singlePrice'] =$price ;
                $productInfos[$productId ]['name'] =$product->name ;
                $productInfos[$productId ]['productId'] =$productId  ;


            }
        }

        $response['checkoutData'] = $checkoutComplete;
        $response['itemData'] = $productInfos ;
        return $response;

    }

    public function removeInvoice($invoiceId){
        DB::beginTransaction();
        try {
            $checkout = Checkout::with('productItems')->where('id', $invoiceId)->first();
            $checkout->update([
                'status' =>CHECKOUT_REMOVED,
            ]);

            foreach($checkout->productItems as $item){
                $item->update([
                    'checkout_id'=>null,
                    'sold' => ITEM_NOT_SOLD,
                ]);
            }
            DB::commit();
        } catch (\Exception $e) {
            Log::debug('error in remove invoice : ' . $e);
            DB::rollBack();
        }
    }

    public function removeAllPendingInvoice(){
        DB::beginTransaction();
        try {
            $checkouts = Checkout::with('productItems')->whereIn('status', [CHECKOUT_PENDING, CHECKOUT_REMOVED])->get();
            // dd($checkouts );
            foreach($checkouts as $checkout){
                $checkout->update([
                    'status' =>CHECKOUT_REMOVED,
                ]);
                // dd($checkout->productItems);
                foreach($checkout->productItems as $item){
                    $item->update([
                        'checkout_id'=>null,
                        'sold' => ITEM_NOT_SOLD,
                        'promotion_program_id'=>null,
                    ]);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            Log::debug('error in remove all invoice : ' . $e);
            DB::rollBack();
        }
    }


    public function calculateSumInvoice($invoiceId){
        $sum = 0;
        $checkout = Checkout::with('productItems')->where('id', $invoiceId)->first();
        foreach($checkout->productItems as $item){

            if(isset($item->promotion_program_id)){
                // Log::debug($item->promotionProgram->toArray());
                $promotionProgram = PromotionProgram::find($item->promotion_program_id);
                if($promotionProgram->program_type == DISCOUNT_PRODUCT){
                    $discountProductProgram =DiscountProductProgram::where('program_id',$promotionProgram->id)->where('product_id', $item->product->id)->first();
                    $sum = $sum+$discountProductProgram->new_price;
                }
            }else{
                $sum = $sum + $item->product->price;
            }
        }

        return $sum;
    }


}
