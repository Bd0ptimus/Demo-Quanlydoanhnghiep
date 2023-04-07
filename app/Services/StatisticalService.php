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
use App\Models\ProductAttachment;

//service
use App\Services\UtilService;
use Exception;

class StatisticalService
{
    protected $utilService;
    public function __construct(UtilService $utilService){
        $this->utilService = $utilService;
    }

    public function allStatistical($diff){

        //income-cost chart
        // $incomeCostDatas = $this->utilService->incomeCostChart($diff );
        // if($diff == STATISTIC_FOLLOW_MONTH){
        //     $response['incomeCostData']=[['Tháng', 'Doanh thu', 'Chi phí']];

        // }else{
        //     $response['incomeCostData']=[['Năm', 'Doanh thu', 'Chi phí']];

        // }
        // foreach($incomeCostDatas as $incomeCostData){
        //     array_push( $response['incomeCostData'], [$incomeCostData['diff'], intval($incomeCostData['income']), intval($incomeCostData['cost'])]);
        // }


        //income-profit chart
        $incomeProfitCostDatas = $this->utilService->incomeProfitCostChart($diff);
        if($diff == STATISTIC_FOLLOW_MONTH){
            $response['incomeProfitCostData']=[['Tháng', 'Chi phí','Doanh thu', 'Lợi nhuận']];

        }else{
            $response['incomeProfitCostData']=[['Năm', 'Chi phí','Doanh thu', 'Lợi nhuận']];

        }
        foreach($incomeProfitCostDatas as $incomeProfitCostData){
            array_push( $response['incomeProfitCostData'], [$incomeProfitCostData['diff'], intval($incomeProfitCostData['cost']),intval($incomeProfitCostData['income']), intval($incomeProfitCostData['profit'])]);
        }
        return $response;

    }

}
