<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\PromotionProgramService;
use App\Services\UtilService;

class TestController extends Controller
{
    protected $promotionProgramService;
    protected $utilService;
    public function __construct(PromotionProgramService $promotionProgramService, UtilService $utilService){
        $this->promotionProgramService = $promotionProgramService;
        $this->utilService = $utilService;

    }
    public function testAlgorithm(Request $request){
        // dd('test');
        $data = [
            [
                'promotionId' => 1,
                'newPrice' => 10000,
            ],
            [
                'promotionId' => 2,
                'newPrice' => 20000,
            ],
            [
                'promotionId' => 3,
                'newPrice' => 5000,
            ],
            [
                'promotionId' => 4,
                'newPrice' => 7000,
            ],
            [
                'promotionId' => 5,
                'newPrice' => 100,
            ],
            [
                'promotionId' => 6,
                'newPrice' => 12000,
            ],
            [
                'promotionId' => 7,
                'newPrice' => 19000,
            ],
            [
                'promotionId' => 8,
                'newPrice' => 2000,
            ],
            [
                'promotionId' => 9,
                'newPrice' => 3000,
            ],
        ];
        // dd($data);
        dd($this->utilService->findMinMaxInArr($data, 0, count($data)-1));
    }
}
