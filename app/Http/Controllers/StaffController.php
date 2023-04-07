<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;


use App\Models\User;
use App\Models\Staff;

use App\Services\StaffService;
use App\Services\TimeSheetService;

use Carbon\Carbon;
class StaffController extends Controller
{
    protected $staffService;
    protected $timeSheetService;
    public function __construct(StaffService $staffService, TimeSheetService $timeSheetService)
    {
        $this->middleware('admin.auth');
        $this->staffService = $staffService;
        $this->timeSheetService = $timeSheetService;
    }

    public function staffList(Request $request)
    {
        $staffs = $this->staffService->takeAllStaffs();
        return view('admin.staff.staffList', [
            'staffs' => $staffs,
        ]);
    }


    private function addStaffValidator($request)
    {
        $messages = [
            'name.required' => 'Tên nhân viên mới bắt buộc phải được nhập.',
            // 'salary.numeric' => 'Lương nhân viên mới phải là số.',
            'positionTitle.required' => 'Chức vụ nhân viên mới bắt buộc phải được nhập.',

        ];

        $validator = Validator::make($request, [
            'name'    => 'required',
            // 'salary'    => 'numeric',
            'positionTitle' => 'required'

        ], $messages);

        return $validator;
    }

    public function addStaff(Request $request)
    {
        $superiors = $this->staffService->takeAllSuperiors();
        if ($request->isMethod('POST')) {
            $validator = $this->addStaffValidator($request->all());
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all());
            } else {
                $email = User::where('email', $request->email)->first();
                if (isset($email)) {
                    return redirect()->back()->withErrors($validator->errors()->add('email', 'Email này đã tôn tại'))->withInput($request->all());
                }

                if($request->immediateSuperior == 0){
                    return redirect()->back()->withErrors($validator->errors()->add('immediateSuperior', 'Phải chọn cấp trên trực tiếp'))->withInput($request->all());
                }

                if(!is_array($request->shift)){
                    return redirect()->back()->withErrors($validator->errors()->add('shift', 'Phải chọn ca làm việc'))->withInput($request->all());
                }
                $this->staffService->addStaff($request);
            }

            return redirect()->route('admin.staff.staffList');
        }

        return view('admin.staff.addStaff', [
            'superiors' => $superiors,
        ]);
    }

    public function timeKeepingIndex(Request $request){
        // dd($request->all()['date']);
        // dd(Carbon::now()->format('d-m-Y'));
        $staffs = User::with('timesheets')->get();
        return view('admin.staff.timeKeeping',[
            'datePicked' => isset($request->all()['date'])?$request->all()['date']:Carbon::now()->format('Y-m-d'),
            'staffs' => $staffs,
        ]);
    }

    public function updateTime(Request $request){
        try{
            $params['shift'] = $request->shift;
            $params['time'] = $request->time;
            $params['startEnd'] = $request->startEnd;
            $params['date'] = $request->date;
            $params['userId'] = $request->userId;

            $this->timeSheetService->updateTimeSheet($params);

        }catch(\Exception $e){
            LOG::debug('error in addCategory : ' . $e );
            return response()->json(['error' => 1, 'msg' => 'Đã có lỗi']);
        }
        return response()->json(['error' => 0, 'msg' => 'update complete']);
    }


    public function salaryIndex(Request $request){
        $staffs = User::with('timesheets')->get();
        return view('admin.staff.salary',[
            'monthPicked'=>isset($request->all()['month'])?$request->all()['month']:Carbon::now()->format('Y-m'),
            'staffs' => $staffs,
        ]);
    }

    public function updateSalary(Request $request, $userId){
        if($request->isMethod('POST')){
            Staff::where('user_id', $userId)->update([
                'salary'=>$request->salary,
            ]);
            return redirect()->route('admin.staff.salary.salaryIndex');
        }

        $staff = User::with('staff')->where('id', $userId)->first();
        // dd($staff->user );
        return view('admin.staff.updateSalary',[
            'staff'=>$staff,
        ]);
    }

    public function staffTree(Request $request){
        $users = User::get();
        $userTreeData = [];
        foreach($users as $user){
            $userData=[];
            $userData['name'] = $user->name;
            $userData['id'] = $user->id;
            $userData['title'] = $user->position_title;

            if($user->pid != 0 ) {
                $userData['pid'] = $user->pid;
            }
            array_push($userTreeData,$userData);
        }
        // dd( $userTreeData);
        return view('admin.staff.staffTree',[
            'userTreeData' => $userTreeData,
        ]);
    }
}
