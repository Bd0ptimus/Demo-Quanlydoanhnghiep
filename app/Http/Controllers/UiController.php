<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\Ui;

use App\Services\AttachmentService;
class UiController extends Controller
{
    protected $attachmentService;
    public function __construct(AttachmentService $attachmentService){
        $this->middleware('admin.auth')->except(['showInvoice']);
        $this->attachmentService = $attachmentService;
    }

    public function index(Request $request){
        // dd('abc');
        return view('admin.ui.index');
    }

    public function addBackground(Request $request){
        error_reporting(E_ALL ^ E_NOTICE);
        if(isset($request->background)){
            $this->attachmentService->addNewUi($request->background, 'background_url');
        }else{
            Ui::first()->update([
                'background_url'=>'',
            ]);
        }
        return view('admin.ui.index');
    }

    public function addHeader(Request $request){
        error_reporting(E_ALL ^ E_NOTICE);
        if(isset($request->header)){
            $this->attachmentService->addNewUi($request->header, 'header_url');
        }else{

            Ui::first()->update([
                'header_url'=>'',
            ]);
        }
        return view('admin.ui.index');
    }
}
