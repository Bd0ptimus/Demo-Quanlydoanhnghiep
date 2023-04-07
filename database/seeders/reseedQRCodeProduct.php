<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\Storage;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;

use BaconQrCode\Writer;
use DateTime;
use App\Models\Product;
class reseedQRCodeProduct extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

     public function generateName()
    {
        $now = DateTime::createFromFormat('U.u', number_format(microtime(true), 6, '.', ''), new \DateTimeZone('UTC'));
        $string = (int)$now->format("Uu");
        return $string;
    }
    public function generateQRCode($url)
     {
         $size = QRCODE_SIZE;
         $renderer = new ImageRenderer(new \BaconQrCode\Renderer\RendererStyle\RendererStyle($size), new SvgImageBackEnd());
         $writer = new Writer($renderer);
         $qrCode = $writer->writeString($url);
         $fileName =  $this->generateName().'.svg';
         $path = 'public/product_item_qrcode/' . $fileName;
         Storage::put($path, $qrCode);
         return asset('storage/product_item_qrcode/'. $fileName);
     }
    public function run()
    {

        $products=Product::get();
        foreach($products as $product){
            $newProductUrl = route('product.index', ['productId' => $product->id]);
            $qrcodeUrl = $this->generateQRCode($newProductUrl);
            $product->update([
                'url_qr_code'=>$qrcodeUrl ,
            ]);

        }


    }
}
