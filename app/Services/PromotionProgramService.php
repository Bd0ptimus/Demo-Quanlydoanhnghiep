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
use App\Models\PromotionProgram;
use App\Models\Product;
use App\Models\ProductItem;
use App\Models\DiscountProductProgram;

use App\Services\UtilService;
use Exception;
class PromotionProgramService
{
    protected $utilService;
    public function __construct(UtilService $utilService){
        $this->utilService = $utilService;
    }
    public function takeDiscountPrograms(){
        // dd()
        return PromotionProgram::with('discountProductPrograms')->orderBy('created_at', 'DESC')->get();
    }

    public function deleteProgram($programId){
        return PromotionProgram::find($programId)->delete();
    }
    public function createDiscountProgram($request){
        DB::beginTransaction();
        try{

            $dateFrom = strtr(trim(explode('-', $request->daterange)[0]), '/', '-');
            $dateTo = strtr(trim(explode('-', $request->daterange)[1]), '/', '-');
            Log::debug($request->daterange);
            $newProgram = PromotionProgram::create([
                'name'=>$request->name,
                'program_code' => $request->programCode,
                'start_date' => date("Y-m-d H:i:s", strtotime($dateFrom)),
                'end_date' => date("Y-m-d H:i:s", strtotime($dateTo)),
                'program_type' =>DISCOUNT_PRODUCT,

            ]);
            $discountType = $request->discountType;
            foreach($request->productApply  as $product){
                $productPrice = Product::find($product)->price;
                if($discountType == DISCOUNT_WITH_PERCENT){
                    $newPrice =$productPrice - $productPrice*($request->discountRate/100);
                }else{
                    $newPrice =$productPrice - $request->discountRate;
                }
                DiscountProductProgram::create([
                    'program_id' => $newProgram->id,
                    'product_id' => $product,
                    'new_price' => $newPrice,
                ]);
            }

            DB::commit();
        }catch(Exception $e){
            Log::debug('error in create discount program : ' . $e);
            DB::rollBack();
        }
    }

    public function takeAllPromotionProductWithId($productId){
        $currentTime = now();
        $response=[];

        $discountProgram['data'] = DiscountProductProgram::where('product_id',  $productId)->whereHas('promotionProgram', function($query) use ($currentTime){
            $query->where('start_date', '<=', $currentTime)->where('end_date', '>=', $currentTime);
        })->get();

        // Log::debug(print_r($discountProgram['data'], true));
        // Log::debug($discountProgram['data']->count());

        if($discountProgram['data']->count() == 0){
            return null;
        }
        $discountProgram['program_id']=DISCOUNT_PRODUCT;
        array_push($response, $discountProgram);

        return $response;
    }

    private function checkProgramProduct($programId, $productId){
        $program = PromotionProgram::find($programId);
        if($program->program_type == DISCOUNT_PRODUCT){
            $result = DiscountProductProgram::where('program_id', $programId)->where('product_id', $productId)->first();
        }

        return isset($result);
    }

    public function applyPromotionForProduct($request){
        $program = PromotionProgram::find($request->programId);
        $result=null;
        if($program->program_type == DISCOUNT_PRODUCT){
            $result = DiscountProductProgram::where('program_id', $request->programId)->where('product_id', $request->productId)->first();
        }
        return $result;
    }

    public function applyPromotionForItemInInvoice($request){
        $response = null;
        DB::beginTransaction();
        try{
            $item= ProductItem::where('checkout_id', $request->invoiceId)->where('id', $request->itemId)->first();
            if(isset($item->promotion_program_id) &&$item->promotion_program_id == $request->promotionId ){
                ProductItem::where('checkout_id', $request->invoiceId)->where('product_id',$item->product->id)->update([
                    'promotion_program_id' => null,
                ]);
            }else{
                ProductItem::where('checkout_id', $request->invoiceId)->where('product_id',$item->product->id)->update([
                    'promotion_program_id' => $request->promotionId,
                ]);
            }
            $response['productItems'] =ProductItem::where('checkout_id', $request->invoiceId)->get();
            $response['discountItem'] =DiscountProductProgram::where('program_id', $request->promotionId)->where('product_id', $item->product->id)->first();
            DB::commit();
        }catch(Exception $e){
            Log::debug('error in applyPromotionForItemInInvoice : ' . $e);
            DB::rollBack();
        }

        return $response;
    }

    public function preferBestPromotionProgram($promotionProducts){
        $dataForFind=[];
        foreach($promotionProducts as $promotionProduct){
            foreach($promotionProduct['data'] as $promotionProductData){
                $data['promotionId']=$promotionProductData->promotionProgram->id;
                $data['newPrice']=$promotionProductData->new_price;
                array_push($dataForFind, $data);
            }
        }
        return ($this->utilService->findMinMaxInArr($dataForFind, 0, count($dataForFind)-1));
    }


}
