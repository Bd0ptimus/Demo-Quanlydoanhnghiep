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
use App\Models\Ui;

//service
use App\Services\UtilService;
use Exception;

class AttachmentService
{
    protected $utilService;
    public function __construct(UtilService $utilService)
    {
        $this->utilService = $utilService;
    }

    public function addNewProductAttachment($productId, $request)
    {
        $data['desPhoto'] = [];
        if (isset($request->desPhotoUpload)) {
            foreach ($request->desPhotoUpload as $desPhoto) {
                $desPhotoName = $this->utilService->generateName() . '.jpg';
                $desPhoto->move(storage_path('app/public/product_attachments'), $desPhotoName);
                array_push($data['desPhoto'], asset('storage/product_attachments/' . $desPhotoName));
                ProductAttachment::create([
                    'url' => asset('storage/product_attachments/' . $desPhotoName),
                    'product_id' => $productId,
                ]);
            }
        }
        return $data['desPhoto'];
    }

    public function addNewUi($requestImg, $slug)
    {
        $uiImgName = $this->utilService->generateName() . '.jpg';
        $requestImg->move(storage_path('app/public/assets'), $uiImgName);
        $ui=Ui::first();
        $url =  asset('storage/assets/' . $uiImgName);
        $ui->update([
            $slug=> $url,
        ]);
        // dd($ui);
        return $url;
    }


    public function removeAttachmentsInStorageByProductId($productId)
    {
        $attachments = ProductAttachment::where('product_id', $productId)->get();
        foreach ($attachments as $attachment) {
            $this->utilService->removeAttachmentInStorageByUrl('product_attachments', $attachment->url);
        }
    }
}
