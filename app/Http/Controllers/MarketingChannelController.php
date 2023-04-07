<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PromotionProgramService;
class MarketingChannelController extends Controller
{
    protected $promotionProgramService;
    public function __construct(PromotionProgramService $promotionProgramService) {
        $this->middleware('admin.auth')->except(['showInvoice']);
        $this->promotionProgramService = $promotionProgramService;
    }

    public function index(Request $request){
        return view('admin.marketingChannel.index');
    }

    public function deleteProgram(Request $request, $programId){
        $this->promotionProgramService->deleteProgram($programId);
        return redirect()->back();
    }

    //discount product
    public function discountProductIndex(Request $request){
        $programs = $this->promotionProgramService->takeDiscountPrograms();
        return view('admin.marketingChannel.discount.index',[
            'programs' => $programs,
        ]);
    }

    public function addDiscountProduct(Request  $request){
        if($request->isMethod('POST')){
            $this->promotionProgramService->createDiscountProgram($request);
            return redirect()->route('admin.marketingChannel.discountProduct.index');
        }
        return view('admin.marketingChannel.discount.addDiscountProductProgram');
    }


}
