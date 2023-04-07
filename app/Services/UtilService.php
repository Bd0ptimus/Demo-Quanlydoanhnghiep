<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

use DateTime;

//model
use App\Models\Checkout;
use App\Models\Cost;

//service
use Exception;
class UtilService
{
    public function generateName()
    {
        $now = DateTime::createFromFormat('U.u', number_format(microtime(true), 6, '.', ''), new \DateTimeZone('UTC'));
        $string = (int)$now->format("Uu");
        return $string;
    }

    public function removeAttachmentInStorageByUrl($folderName, $url){
        $filename = basename($url);
        Storage::delete('public/'.$folderName.'/' . $filename);
    }

    private function getMonthListFromDate(Carbon $start)
    {
        foreach (CarbonPeriod::create($start, '1 month', Carbon::today()) as $month) {
            $months[$month->format('m-Y')] = $month->format('m-Y');
        }
        return $months;
    }
    private function getYearListFromDate(Carbon $start)
    {
        foreach (CarbonPeriod::create($start, '1 year', Carbon::today()) as $month) {
            $months[$month->format('Y')] = $month->format('Y');
        }
        return $months;
    }

    public function incomeCostChart($index){
        $data=[];
        if($index==STATISTIC_FOLLOW_MONTH){
            $diffs = $this->getMonthListFromDate(Carbon::createFromFormat('d/m/Y', DATE_START_TRACKING_MONTH));
            foreach($diffs as $diff){
                $data[$diff]['diff'] = $diff;
                $data[$diff]['income'] = Checkout::where('status',CHECKOUT_DONE )->whereMonth('created_at',  $diff)->sum('pay_amount');
                $data[$diff]['cost'] = Cost::whereMonth('created_at',  $diff)->sum('cost');
            }

        }else if($index == STATISTIC_FOLLOW_YEAR){
            $diffs = $this->getYearListFromDate(Carbon::createFromFormat('d/m/Y', DATE_START_TRACKING_YEAR));
            foreach($diffs as $diff){
                $data[$diff]['diff'] = $diff;
                $data[$diff]['income'] = Checkout::where('status',CHECKOUT_DONE )->whereYear('created_at',  $diff)->sum('pay_amount');
                $data[$diff]['cost'] = Cost::whereYear('created_at',  $diff)->sum('cost');
            }
        }

        // dd($diffs);

        return $data;
    }

    public function incomeProfitCostChart($index){
        $data=[];
        if($index==STATISTIC_FOLLOW_MONTH){
            $diffs = $this->getMonthListFromDate(Carbon::createFromFormat('d/m/Y', DATE_START_TRACKING_MONTH));
            foreach($diffs as $diff){
                $data[$diff]['diff'] = $diff;
                $income =  Checkout::where('status',CHECKOUT_DONE )->whereMonth('created_at',  $diff)->sum('pay_amount');
                $cost = Cost::whereMonth('created_at',  $diff)->sum('cost');

                $data[$diff]['income'] =   $income ;
                $data[$diff]['cost'] =   $cost ;
                $data[$diff]['profit'] =$income - $cost;
            }

        }else if($index == STATISTIC_FOLLOW_YEAR){
            $diffs = $this->getYearListFromDate(Carbon::createFromFormat('d/m/Y', DATE_START_TRACKING_YEAR));
            foreach($diffs as $diff){
                $data[$diff]['diff'] = $diff;
                $income = Checkout::where('status',CHECKOUT_DONE )->whereYear('created_at',  $diff)->sum('pay_amount');
                $cost = Cost::whereYear('created_at',  $diff)->sum('cost');

                $data[$diff]['income'] =   $income ;
                $data[$diff]['cost'] =   $cost ;
                $data[$diff]['profit'] =$income - $cost;
            }
        }

        return $data;
    }

    public function findMinMaxInArr($arr, $l, $r){
        $max=[];
        $min=[];
        if($l == $r){
            $max = $arr[$l];
            $min = $arr[$l];

        }else if($l+1==$r){
            if($arr[$l]['newPrice'] < $arr[$r]['newPrice']){
                $max = $arr[$r];
                $min = $arr[$l];
            }else{
                $max = $arr[$l];
                $min = $arr[$r];
            }
        }else{
            $mid = floor(($l+$r)/2);
            $leftMinMax =$this->findMinMaxInArr($arr , $l, $mid);
            $rightMinMax =$this->findMinMaxInArr($arr , $mid+1, $r);
            if($leftMinMax[0]['newPrice'] > $rightMinMax[0]['newPrice']){
                $max = $leftMinMax[0];
            }else{
                $max = $rightMinMax[0];
            }

            if($leftMinMax[1]['newPrice'] < $rightMinMax[1]['newPrice']){
                $min = $leftMinMax[1];
            }else{
                $min = $rightMinMax[1];
            }

        }

        $maxMin[0] = $max;
        $maxMin[1] = $min;
        return $maxMin;
    }
}
