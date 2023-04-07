<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cost;

use App\Services\CostService;
use App\Models\CostType;
class CostController extends Controller
{
    protected $costService;
    public function __construct(Request $request,
    CostService $costService ){
        $this->middleware('admin.auth');
        $this->costService = $costService;
    }

    public function index(Request $request){
        $costs = Cost::get();
        $types = CostType::get();

        return view('admin.cost.index',[
            'costs' => $costs,
            'types' => $types,

        ]);
    }

    public function addCost(Request $request){
        if($request->isMethod('POST')){
            $this->costService->addCost($request);
            return redirect()->route('admin.cost.index');
        }
        return view('admin.cost.addCost');
    }

    public function costsList(Request $request){
        $types = CostType::get();
        return view('admin.cost.costsList',[
            'types' => $types,
        ]);
    }

    public function addCostType(Request $request){
        if($request->isMethod('POST')){
            CostType::create([
                'name' => $request->name,
                'cost_type' => $request->costType,
            ]);
            // return redirect()->route('admin.cost.costsList');
            return redirect()->route('admin.cost.index');
        }

        return view('admin.cost.addCostType');
    }

    public function deleteCostType(Request $request, $costTypeId){
        CostType::find($costTypeId)->delete();
        return redirect()->route('admin.cost.index');

    }
}
