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
use App\Models\Cost;
use App\Models\ProductItem;
//service
use App\Services\UtilService;

use App\Admin;
use Exception;
class CostService
{
    public function takeTotalCost(){
        return Cost::sum('cost');
    }
    public function addCost($request){
        Cost::create([
            'note' => $request->note??'',
            'cost' => $request -> cost,
            'date_pay' => $request->datePay??null,
            'cost_type' => $request -> costType,
        ]);
    }

}
