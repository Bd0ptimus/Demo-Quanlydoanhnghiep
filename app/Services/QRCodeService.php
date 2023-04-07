<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Str;
use Carbon\Carbon;
use DateTime;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Writer;
use App\Services\UtilService;

use App\Models\ProductItem;
use Exception;

class QRCodeService
{
    protected $utilService;
    public function __construct(UtilService $utilService){
        $this->utilService = $utilService;
    }
    public function generateQRCode($url)
    {
        $size = QRCODE_SIZE;
        $renderer = new ImageRenderer(new \BaconQrCode\Renderer\RendererStyle\RendererStyle($size), new SvgImageBackEnd());
        $writer = new Writer($renderer);
        $qrCode = $writer->writeString($url);
        $fileName =  $this->utilService->generateName().'.svg';
        $path = 'public/product_item_qrcode/' . $fileName;
        Storage::put($path, $qrCode);
        return asset('storage/product_item_qrcode/'. $fileName);
    }

    public function removeQRCodeInStorageByProductId($productId){
        $items =ProductItem::where('product_id', $productId)->get();
        foreach($items as $item){
            $this->utilService->removeAttachmentInStorageByUrl('product_item_qrcode', $item->url_qr_code);
        }
    }
}
