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
use App\Models\TimeSheet;

//service
use App\Services\UtilService;
use Exception;

class TimeSheetService
{
    public function updateTimeSheet($params){
        $timeSheet = TimeSheet::where('user_id', $params['userId'])->where('date', $params['date'])->first();
        if(isset($timeSheet)){
            $column = '';
            if($params['shift'] == MORNING_SHIFT){
                if($params['startEnd'] == START_SHIFT){
                    $column = 'start_morning';
                }else{
                    $column = 'end_morning';
                }
            }else if($params['shift'] == AFTERNOON_SHIFT){
                if($params['startEnd'] == START_SHIFT){
                    $column = 'start_afternoon';
                }else{
                    $column = 'end_afternoon';
                }

            }else if($params['shift'] == EVENING_SHIFT){
                if($params['startEnd'] == START_SHIFT){
                    $column = 'start_evening';
                }else{
                    $column = 'end_evening';
                }
            }
            $timeSheet->update([
                $column => $params['time'],
            ]);

        }else{
            $column = '';
            if($params['shift'] == MORNING_SHIFT){
                if($params['startEnd'] == START_SHIFT){
                    $column = 'start_morning';
                }else{
                    $column = 'end_morning';
                }
            }else if($params['shift'] == AFTERNOON_SHIFT){
                if($params['startEnd'] == START_SHIFT){
                    $column = 'start_afternoon';
                }else{
                    $column = 'end_afternoon';
                }

            }else if($params['shift'] == EVENING_SHIFT){
                if($params['startEnd'] == START_SHIFT){
                    $column = 'start_evening';
                }else{
                    $column = 'end_evening';
                }
            }
            TimeSheet::create([
                'user_id'=>$params['userId'],
                'date' => $params['date'],
                $column =>$params['time'],
            ]);
        }
    }

}
