<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Admin;
use PDF;

use App\Services\ProductService;
use App\Services\AttachmentService;
use App\Services\InvoiceService;
use App\Services\CostService;
use App\Services\UtilService;
use App\Services\StatisticalService;
use App\Services\PromotionProgramService;

use App\Models\Product;
use App\Models\ProductItem;
use App\Models\DiscountProductProgram;
use App\Models\CategoryProduct;
use App\Models\Warehouse;

use function PHPUnit\Framework\isEmpty;

class AdminController extends Controller
{
    protected $productService;
    protected $attachmentService;
    protected $invoiceService;
    protected $costService;
    protected $utilService;
    protected $statisticalService;
    protected $promotionProgramService;
    public function __construct(
        ProductService $productService,
        AttachmentService $attachmentService,
        InvoiceService $invoiceService,
        CostService $costService,
        UtilService  $utilService,
        StatisticalService $statisticalService,
        PromotionProgramService $promotionProgramService
    ) {
        $this->middleware('admin.auth')->except(['showInvoice']);
        $this->productService = $productService;
        $this->attachmentService = $attachmentService;
        $this->invoiceService = $invoiceService;
        $this->costService = $costService;
        $this->utilService = $utilService;
        $this->statisticalService = $statisticalService;
        $this->promotionProgramService = $promotionProgramService;
    }


    //Products manager
    public function productManager(Request $request)
    {
        $categories = $this->productService->takeAllCategories();
        $products = $this->productService->takeAllProducts();
        $warehouses = Warehouse::get();
        return view('admin.product.index', [
            'products' => $products,
            'categories' => $categories,
            'warehouses' => $warehouses,
        ]);
    }

    private function addProductValidator($request)
    {
        $messages = [
            'name.required' => 'Tên sản phẩm mới bắt buộc phải được nhập.',
            'price.required' => 'Giá sản phẩm mới bắt buộc phải được nhập.',
            'price.numeric' => 'Giá sản phẩm mới phải là số.',

        ];

        $validator = Validator::make($request, [
            'name'    => 'required',
            'price'    => 'required|numeric',


        ], $messages);

        return $validator;
    }
    public function addProduct(Request $request)
    {
        if ($request->isMethod('POST')) {
            $validator = $this->addProductValidator($request->all());
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all());
            } else {
                DB::beginTransaction();
                try {
                    $newProduct = $this->productService->addNewProduct($request);
                    $this->attachmentService->addNewProductAttachment($newProduct->id, $request);
                    DB::commit();
                } catch (\Exception $e) {
                    Log::debug('error in add product : ' . $e);
                    DB::rollBack();
                }
            }
            return redirect()->route('admin.product.index');
        }
        $categories = $this->productService->takeAllCategories();
        $warehouses = Warehouse::get();
        return view('admin.product.createProduct', [
            'categories' => $categories,
            'warehouses' => $warehouses,
        ]);
    }

    public function addCategory(Request $request)
    {
        if ($request->isMethod('POST')) {
            CategoryProduct::create([
                'category_name' => $request->name,
                'description' => $request->description,
            ]);
            return redirect()->route('admin.product.index');
        }
        return view('admin.product.createCategory');
    }

    public function addWarehouse(Request $request)
    {
        if ($request->isMethod('POST')) {
            Warehouse::create([
                'name' => $request->name,
                'address' => $request->address,
            ]);
            return redirect()->route('admin.product.index');
        }
        return view('admin.product.createWarehouse');
    }

    public function updateProduct(Request $request, $productId)
    {
        if ($request->isMethod('POST')) {
            DB::beginTransaction();
            try {
                $this->productService->updateProduct($request, $productId);
                DB::commit();
            } catch (\Exception $e) {
                Log::debug('error in update product : ' . $e);
                DB::rollBack();
            }
            return redirect()->route('admin.product.index');
        }
        $product = Product::with('productAttachments')->find($productId);
        $productImages = [];
        $productImages = $product->productAttachments->pluck('url')->toArray();
        $categories = $this->productService->takeAllCategories();
        // dd( $categories[2]->products->where('id', $product->id)->first());
        // array_push($productImages, $product->productAttachments->pluck('url')->toArray());
        return view('admin.product.updateProduct', [
            'product' => $product,
            'images' => $productImages,
            'categories' => $categories,
        ]);
    }

    public function increaseProductItem(Request $request, $productId)
    {
        DB::beginTransaction();
        try {
            $product = $this->productService->increaseItems($request, $productId);
            DB::commit();
        } catch (\Exception $e) {
            Log::debug('error in increase product : ' . $e);
            DB::rollBack();
        }

        return view('admin.product.qrSheetRender', [
            'product' => $product,
        ]);
    }

    public function resetProductItem(Request $request, $productId)
    {
        DB::beginTransaction();
        try {
            $this->productService->resetItems($request, $productId);

            DB::commit();
        } catch (\Exception $e) {
            Log::debug('error in add product : ' . $e);
            DB::rollBack();
        }

        return redirect()->route('admin.product.index');
    }

    public function deleteProduct(Request $request, $productId)
    {
        $this->productService->deleteProduct($productId);
        return redirect()->back();
    }

    public function deleteCategory(Request $request, $categoryId)
    {
        CategoryProduct::find($categoryId)->delete();
        return redirect()->back();
    }

    public function deleteWarehouse(Request $request, $warehouseId)
    {
        Warehouse::find($warehouseId)->delete();
        return redirect()->back();
    }

    public function amountDetail(Request $request){
        try {
            $productId = $request->productId;
            $data['tableHtml']='';
            // $product = Product::with(['warehouses' => function ($query) {
            //     $query->select('warehouse_id', 'amount', 'name')
            //     ->join('warehouse_product', 'warehouse_product.warehouse_id', '=', 'warehouses.id')
            //     ->withPivot('product_id');
            // }])->find($productId);

            $product = Product::with(['warehouses'])->where('id', $productId)->first();
            // Log::debug(print_r($product->warehouses, true));
            $data['name'] = $product->name;
            foreach ($product->warehouses as $warehouse) {
                // $warehouse->pivot->amount;
                $data['tableHtml'] = $data['tableHtml'] . ' <tr>
                                                                <td scope="col">'.$warehouse->name.'</td>
                                                                <td scope="col">'.$warehouse->pivot->amount.'</td>
                                                            </tr>';
            }
        } catch (\Exception $e) {
            LOG::debug('error in addCategory : ' . $e);
            return response()->json(['error' => 1, 'msg' => 'Đã có lỗi']);
        }
        return response()->json(['error' => 0, 'msg' => 'take amount Data complete', 'data' => $data]);
    }

    //Invoice
    public function createInvoice(Request $request)
    {
        $warehouses = Warehouse::get();
        $select2Datas = [];
        foreach ($warehouses as $warehouse) {
            array_push($select2Datas, [
                'value' => $warehouse->id,
                'data' =>  $warehouse->name,
            ]);
        }
        $select2Choice = isset($request->all()['warehouse']) ? $request->all()['warehouse'] : $warehouses[0]->id;
        $products = Warehouse::where('id', $select2Choice)->with(['products', 'products.productAttachments'])->first()->products;
        // dd($products);
        // $products = Product::with('productAttachments')->get();
        return view('admin.invoice.createInvoice', [
            'products' => $products,
            'select2Datas' => $select2Datas,
            'select2Name' => 'warehouse',
            'select2Choice' => $select2Choice,
            'warehouseChoice' => $select2Choice,
        ]);
    }

    public function addItemToInvoice(Request $request)
    {
        try {
            $productId = $request->productId;
            $warehouseId = $request->warehouseId;
            $product = Product::where('id', $productId)->with('warehouses', function ($query) use ($warehouseId) {
                $query->where('warehouse_id', $warehouseId)->wherePivot('amount', '>', 0);
            })->first();

            if (($product->warehouses->first()) !== null) {
                $promotionProducts = $this->promotionProgramService->takeAllPromotionProductWithId($request->productId);

                $data['name'] = $product->name;
                $data['id'] = $product->id;
                $data['singlePrice'] = $product->price;
                $data['priceAfterPromotion'] = $product->price;
                $data['amount'] = $request->amountId;
                $data['promotionId'] = null;
                $promotionCards = '';

                if (isset($promotionProducts)) {
                    $bestPromotion = $this->promotionProgramService->preferBestPromotionProgram($promotionProducts)[1];

                    $data['priceAfterPromotion'] = $bestPromotion['newPrice'];
                    $data['promotionId'] = $bestPromotion['promotionId'];

                    foreach ($promotionProducts as $promotionProduct) {
                        $promotionCardStatus = 'promotion-card-unactive';
                        $promotionCheckIcon = 'display:none;';
                        if ($promotionProduct['program_id'] == DISCOUNT_PRODUCT) {
                            $programRelation = 'promotionProgram';
                        }
                        foreach ($promotionProduct['data'] as $promotionProductData) {

                            $promotionCards = $promotionCards . "<div onclick='promotionChoose(" . $request->productId . "," . $promotionProductData->$programRelation->id . ")' class='promotion-card " . $promotionCardStatus . " d-block promotionClass-" . $request->productId . "' id='promotionProgram-" . $request->productId . "-" . $promotionProductData->$programRelation->id . "'>
                                                                    <div>
                                                                        <h6 class='promotion-card-tittle'>" . $promotionProductData->$programRelation->name . "</h6>
                                                                    </div>
                                                                    <div class='d-block'>
                                                                        <p class='promotion-card-text'>Giảm giá còn :" . number_format($promotionProductData->new_price) . " VND</p>
                                                                    </div>
                                                                    <i class='fa-solid fa-check' id='checkIcon-" . $request->productId . "-" . $promotionProductData->$programRelation->id . "' style='" . $promotionCheckIcon . " position : absolute; top:0px; right:0px; color:#EC1D23'></i>
                                                                </div>";
                        }
                    }
                } else {
                    $data['priceAfterPromotion'] = $product->price;
                    $data['promotionId'] = null;
                    $promotionCards = '<p class="text-danger">Không có khuyến mãi</p>';
                }

                $itemHtml = '';
                $onclick = "removeFromInvoice({$request->productId})";
                $itemHtml = $itemHtml . "<tr id='product-" . $request->productId . "' style='min-height:80px; background-color:white; max-height:90px !important;'>
                                    <td><input onchange='amountChoiceHandler(" . $product->id . ")' value='" . $request->amountId . "' id='amountChoice-" . $product->id . "' type='number' class='amountChoice form-control' style='width:120px;'/></td>
                                    <td>" . $product->name . "</td>
                                    <td id='price-" . $request->productId . "'>" . number_format($product->price)  . "</td>

                                    <td>
                                       " .  $request->amountId . "

                                    </td>
                                    <td id='totalPrice-" . $request->productId . "'>" . number_format($product->price *  $request->amountId) . "</td>


                                    <td class='d-block justify-content-start promotion-container' style='height:100%;'>
                                        " . $promotionCards . "
                                    </td>
                                    <td>
                                        <i class='fa-solid fa-trash fa-xl text-danger'
                                            style='height:30px;' onclick={$onclick}>
                                        </i>
                                    </td>
                                </tr>";
                $data['itemHtml'] = $itemHtml;
                $data['productIsValid'] = true;
            } else {
                $data['productIsValid'] = false;
            }
        } catch (\Exception $e) {
            LOG::debug('error in addCategory : ' . $e);
            return response()->json(['error' => 1, 'msg' => 'Đã có lỗi']);
        }
        return response()->json(['error' => 0, 'msg' => 'add item complete', 'data' => $data]);
    }

    public function removeFromInvoice(Request $request)
    {
        try {
            $checkout = $this->invoiceService->removeItemFromInvoice($request);
            if (isset($checkout)) {
                $data['addCompleted'] = 1;
                $data['items'] = [];
                $data['sum'] = $this->invoiceService->calculateSumInvoice($checkout->id);;
                $itemHtml = '';
                foreach ($checkout->productItems as $key => $item) {
                    $promotionProducts = $this->promotionProgramService->takeAllPromotionProductWithId($item->product->id);
                    $promotionCards = '';
                    $priceText = '';
                    $fixedPrice = $item->product->price;
                    $promotionPrice = -1;

                    foreach ($promotionProducts as $promotionProduct) {
                        $promotionCardStatus = '';
                        $promotionCheckIcon = '';
                        // Log::debug('promotionProduct $item->id ' .$item->id.' - '. $request->itemId. ' - '.$item->promotion_program_id.' - '. $request->promotionId);
                        if ($item->promotion_program_id == $promotionProduct->promotionProgram->id) {
                            $promotionCardStatus = 'promotion-card-active';
                            $promotionCheckIcon = 'display:block;';
                            $promotionPrice = DiscountProductProgram::where('program_id',  $promotionProduct->promotionProgram->id)->where('product_id', $item->product->id)->first()->new_price;
                        } else {
                            $promotionCardStatus = 'promotion-card-unactive';
                            $promotionCheckIcon = 'display:none;';
                        }
                        $promotionCards = $promotionCards . "<div onclick='promotionChoose(" . $item->id . "," . $promotionProduct->promotionProgram->id . ")' class='promotion-card " . $promotionCardStatus . " d-block promotionClass-" . $item->id . "' id='promotionProgram-" . $item->id . "-" . $promotionProduct->promotionProgram->id . "'>
                                                                <div>
                                                                    <h6 class='promotion-card-tittle'>" . $promotionProduct->promotionProgram->name . "</h6>
                                                                </div>
                                                                <div class='d-block'>
                                                                    <p class='promotion-card-text'>Giảm giá còn :" . number_format($promotionProduct->new_price) . " VND</p>
                                                                </div>
                                                                <i class='fa-solid fa-check' id='checkIcon-" . $item->id . "-" . $promotionProduct->promotionProgram->id . "' style='" . $promotionCheckIcon . " position : absolute; top:0px; right:0px; color:#EC1D23'></i>
                                                            </div>";
                    }

                    if ($promotionPrice  == -1) {
                        $priceText = $priceText . "<p style=' font-size:16px; margin:0px;'>" . number_format($fixedPrice) . "</p>";
                    } else {
                        $priceText = $priceText . "<p style='text-decoration-line: line-through; font-size:12px; margin:0px;'>" . number_format($fixedPrice) . "</p>
                        <p style='font-size:16px; margin:0px;'>" . number_format($promotionPrice) . "</p>";
                    }
                    $onclick = "removeFromInvoice({$item->id})";
                    $itemHtml = $itemHtml . "<tr id='item-" . $item->id . "' style='min-height:80px; max-height:90px !important;'>
                                    <th scope='row'>" . ($key + 1) . "</th>
                                    <td>" . $item->product->name . "</td>
                                    <td>" . $item->id . "</td>

                                    <td>
                                       " . $priceText . "

                                    </td>
                                    <td>
                                        <i class='fa-solid fa-trash fa-xl text-danger'
                                            style='height:30px;' onclick={$onclick}>
                                        </i>
                                    </td>
                                    <td class='d-block justify-content-start promotion-container' style='height:100%;'>
                                        " . $promotionCards . "
                                    </td>
                                </tr>";
                }
                $data['sum'] = number_format($data['sum']) . "  VND";
                $data['itemHtml'] = $itemHtml;
            } else {
                $data['addCompleted'] = 0;
            }
        } catch (\Exception $e) {
            LOG::debug('error in addCategory : ' . $e);
            return response()->json(['error' => 1, 'msg' => 'Đã có lỗi']);
        }
        return response()->json(['error' => 0, 'msg' => 'remove item from invoice complete', 'data' => $data]);
    }

    public function applyPromotionForItem(Request $request)
    {
        try {
            $promotionProgram = $this->promotionProgramService->applyPromotionForProduct($request);
            if (isset($promotionProgram)) {
                $data['id'] = $request->productId;
                $data['priceAfterPromotion'] = $promotionProgram->new_price;
                $data['promotionId'] = $promotionProgram->program_id;
                $data['applyCompleted'] = 1;
            } else {
                $data['applyCompleted'] = 0;
            }
        } catch (\Exception $e) {
            LOG::debug('error in addCategory : ' . $e);
            return response()->json(['error' => 1, 'msg' => 'Đã có lỗi']);
        }
        return response()->json(['error' => 0, 'msg' => 'apply promotion complete', 'data' => $data]);
    }

    public function resetAllItems(Request $request)
    {
        $productItems = ProductItem::get();
        foreach ($productItems as $productItem) {
            $productItem->update([
                'sold' => ITEM_NOT_SOLD,
                'checkout_id' => null,
                'promotion_program_id' => null,
            ]);
        }
    }

    public function removeInvoice(Request $request, $invoiceId)
    {
        $this->invoiceService->removeInvoice($invoiceId);
        return redirect()->route('admin.invoice.createInvoice');
    }

    public function removeUncompletedInvoice(Request $request)
    {
        try {
            $this->invoiceService->removeInvoice($request->invoiceId);
            $invoices = $this->invoiceService->takeAllInvoice();
            $data = '';
            foreach ($invoices as $key => $invoice) {
                $status = '';
                if ($invoice->status == CHECKOUT_PENDING) {
                    $status = '<p style="color:orange">Chưa hoàn thành</p>';
                } elseif ($invoice->status == CHECKOUT_DONE) {
                    $status = '<p style="color:green">Đã xuất</p>';
                } else {
                    $status = '<p style="color:red">Đã hủy</p>';
                }

                $date = $invoice->created_at ? date("d-m-Y H:i:s", strtotime($invoice->created_at)) : "";
                $nameHref = route("invoice.showInvoice", ["invoiceId" => $invoice->id]);
                $nameA = '<a target="_blank" href="' . $nameHref . '">' . '#' . $invoice->id . '</a>';

                $btns = '';
                if ($invoice->status == CHECKOUT_PENDING) {
                    $btns = $btns . '<a class="btn interact-btn" style="background-color:red;"
                                        onclick="removeInvoice(' . $invoice->id . ')">
                                        Hủy hóa đơn</a>
                                    <br>';
                }
                $data = $data .
                    '<tr>
                    <td scope="col">' . ($key + 1) . '</td>
                    <td scope="col">' . $nameA . '</td>
                    <td scope="col">' . number_format($invoice->pay_amount) . '</td>
                    <td scope="col">' . $invoice->user->name . '</td>
                    <td>' . $date . '</td>
                    <td scope="col">' . $status . '</td>
                    <td scope="col">' . $btns . '
                     </td>
                </tr>';
            }
        } catch (\Exception $e) {
            LOG::debug('error in addCategory : ' . $e);
            return response()->json(['error' => 1, 'msg' => 'Đã có lỗi']);
        }
        return response()->json(['error' => 0, 'msg' => 'remove item from invoice complete', 'data' => $data]);
    }

    public function exportInvoiceOld(Request $request, $invoiceId)
    {
        $response = $this->invoiceService->exportInvoiceOld($request, $invoiceId);
        // dd($response['']);
        // dd(isEmpty($response['itemData']));
        // if(isEmpty($response['itemData'])){
        //     return redirect()->route('home');
        // }
        return view('admin.invoice.invoiceComplete', [
            'invoice' => $response['checkoutData'],
            'itemData' => $response['itemData'],
            'sumToPay' => $response['sumToPay'],
        ]);
    }

    public function exportInvoice(Request $request)
    {
        // LOG::debug('in export invoice');
        try {
            $response = $this->invoiceService->exportInvoice($request);
        } catch (\Exception $e) {
            LOG::debug('error in addCategory : ' . $e);
            return response()->json(['error' => 1, 'msg' => 'Đã có lỗi']);
        }
        return response()->json(['error' => 0, 'msg' => 'export invoice complete', 'data' => $response]);
    }

    public function showInvoice(Request $request, $invoiceId)
    {
        $response = $this->invoiceService->showInvoice($invoiceId);
        return view('admin.invoice.showInvoiceComplete', [
            'invoice' => $response['checkoutData'],
            'itemData' => $response['itemData'],
            'sumToPay' => $response['sumToPay'],
        ]);
    }

    public function invoiceList(Request $request)
    {
        $status = isset($request->all()['status']) ? $request->all()['status'] : -1;
        $invoices = $this->invoiceService->takeInvoiceDependOnStatus($status);
        return view('admin.invoice.listInvoice', [
            'invoices' => $invoices,
            'statusSelected' => $status,
        ]);
    }

    public function removeAllPendingInvoice(Request $request)
    {
        $this->invoiceService->removeAllPendingInvoice();
        return redirect()->route('admin.invoice.invoiceList');
    }

    //Dashboard
    public function dashboard(Request $request)
    {
        $statistical = isset($request->all()['statistical']) ? $request->all()['statistical'] : STATISTIC_FOLLOW_MONTH;
        $response = $this->statisticalService->allStatistical($statistical);
        // dd($incomeCostData);
        $totalIncome = $this->invoiceService->takeTotalIncome();
        $totalCost = $this->costService->takeTotalCost();
        $invoices = $this->invoiceService->takeAllCompletedInvoiceOrderByDateCreated();
        return view('admin.dashboard', [
            'totalIncome' => $totalIncome,
            'totalCost' => $totalCost,
            'totalProfit' => $totalIncome - $totalCost,
            'invoices' => $invoices,
            'incomeProfitCostData' => $response['incomeProfitCostData'],
            // 'incomeProfitData' => $response['incomeProfitData'],
            'statistical' => $statistical,
        ]);
    }
}
