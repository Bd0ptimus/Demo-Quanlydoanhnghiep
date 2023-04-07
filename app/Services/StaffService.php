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
use App\Models\Staff;
use App\Models\User;

//service
use App\Services\UtilService;

use App\Admin;
use Exception;
class StaffService
{
    public function takeAllStaffs(){
        return User::with('staff')->orderBy('roles', 'DESC')->get();
    }

    public function takeAllSuperiors(){
        return User::with('staff')->whereIn('roles',[ROLE_CHEF, ROLE_MANAGER, ROLE_TECH_ADMIN])->get();

    }



    public function addStaff($request){
        DB::beginTransaction();
        try{
            $newUser= User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'password_raw' => $request->password,
                'position_title' => $request->positionTitle,
                'pid' => $request->immediateSuperior,
                'roles' => $request->role,
                'status' => ACC_ACTIVATED,
            ]);

            Staff::create([
                'user_id' => $newUser->id,
                'dob' => $request->dob??null,
                'phone' => $request->phone,
                'salary' => $request->salary,
                'shift' =>json_encode( $request->shift),
            ]);
            DB::commit();
        }catch(Exception $e){
            Log::debug('error in add staff : ' . $e);
            DB::rollBack();

        }
    }
}
