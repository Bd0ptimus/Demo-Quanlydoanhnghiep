<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PdfGeneratorController;
use App\Http\Controllers\CostController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\UiController;
use App\Http\Controllers\MarketingChannelController;

Route::group(['prefix' => 'admin', 'as'=>'admin.'], function($route){
    $route->any('/', [AdminController::class, 'index'])->name('index');

    Route::group(['prefix' => 'product', 'as'=>'product.'], function($route){
        $route->any('/', [ AdminController::class, 'productManager'])->name('index');
        $route->any('/add-product', [ AdminController::class, 'addProduct'])->name('addProduct');
        $route->any('/update-product/{productId}', [ AdminController::class, 'updateProduct'])->name('updateProduct');
        $route->get('/delete-product/{productId}', [ AdminController::class, 'deleteProduct'])->name('deleteProduct');
        $route->post('/increase-product-item/{productId}', [ AdminController::class, 'increaseProductItem'])->name('increaseProductItem');
        $route->post('/reset-num-item/{productId}', [ AdminController::class, 'resetProductItem'])->name('resetProductItem');
        $route->get('/print-qr-code/{productId}',[PdfGeneratorController::class, 'index'])->name('printQrCode');
        Route::group(['prefix' => 'category', 'as'=>'category.'], function($route){
            $route->any('/add-category', [ AdminController::class, 'addCategory'])->name('addCategory');
            $route->any('/update-category/{categoryId}', [ AdminController::class, 'updateProduct'])->name('updateProduct');
            $route->get('/delete-category/{categoryId}', [ AdminController::class, 'deleteCategory'])->name('deleteCategory');

        });

        Route::group(['prefix' => 'warehouse', 'as'=>'warehouse.'], function($route){
            $route->any('/add-warehouse', [ AdminController::class, 'addWarehouse'])->name('addWarehouse');
            $route->any('/update-warehouse/{warehouseId}', [ AdminController::class, 'updateProduct'])->name('updateProduct');
            $route->get('/delete-warehouse/{warehouseId}', [ AdminController::class, 'deleteWarehouse'])->name('deleteWarehouse');
            $route->post('/amount-detail', [ AdminController::class, 'amountDetail'])->name('amountDetail');

        });
    });


    Route::group(['prefix' => 'invoice', 'as'=>'invoice.'], function($route){
        $route->any('/create-invoice', [ AdminController::class, 'createInvoice'])->name('createInvoice');
        $route->get('/reset-item', [ AdminController::class, 'resetAllItems'])->name('resetAllItems');
        $route->get('/remove-invoice/{invoiceId}', [ AdminController::class, 'removeInvoice'])->name('removeInvoice');

        $route->post('/add-item',[AdminController::class, 'addItemToInvoice']) -> name('addItem');
        $route->post('/remove-item-from-invoice',[AdminController::class, 'removeFromInvoice']) -> name('removeFromInvoice');
        $route->post('/export-invoice',[AdminController::class, 'exportInvoice'])->name('exportInvoice');
        $route->get('/show-invoice/{invoiceId}',[AdminController::class, 'showInvoice'])->name('showInvoice');
        $route->get('/list-invoice', [AdminController::class, 'invoiceList'])->name('invoiceList');
        $route->post('/remove-invoice-list',[AdminController::class, 'removeUncompletedInvoice'] )->name('removeInvoiceList');
        $route->get('/remove-all-pending-invoice',[AdminController::class, 'removeAllPendingInvoice'] )->name('removeAllPendingInvoice');

    });

    Route::group(['prefix' => 'cost', 'as'=>'cost.'], function($route){
        $route->any('/',[ CostController::class, 'index'] )->name('index');
        $route->any('/add-cost',[ CostController::class, 'addCost'] )->name('addCost');
        $route->get('/costs-list',[ CostController::class, 'costsList'] )->name('costsList');
        $route->any('/add-cost-type',[ CostController::class, 'addCostType'] )->name('addCostType');
        $route->get('/delete-cost-type/{costTypeId}',[ CostController::class, 'deleteCostType'] )->name('deleteCostType');

    });

    $route->any('/dashboard',[AdminController::class, 'dashboard'])->name('dashboard');

    Route::group(['prefix' => 'staff', 'as'=>'staff.'], function($route){
        $route->get('/staff-tree',[ StaffController::class, 'staffTree'] )->name('staffTree');

        $route->get('/staff-list',[ StaffController::class, 'staffList'] )->name('staffList');
        $route->any('/add-staff',[ StaffController::class, 'addStaff'] )->name('addStaff');
        $route->group(['prefix' => 'timekeeping', 'as'=>'timekeeping.'], function($route){
            $route->any('/',[ StaffController::class, 'timeKeepingIndex'] )->name('timeKeepingIndex');
            $route->any('/update-time',[StaffController::class, 'updateTime'])->name('updateTime');
        });
        $route->group(['prefix' => 'salary', 'as'=>'salary.'], function($route){
            $route->any('/',[ StaffController::class, 'salaryIndex'] )->name('salaryIndex');
            $route->any('/update-salary/{userId}',[ StaffController::class, 'updateSalary'] )->name('updateSalary');

        });
    });

    Route::group(['prefix' => 'ui', 'as'=>'ui.'], function($route){
        $route->get('/',[ UiController::class, 'index'] )->name('index');
        $route->post('/add-background',[ UiController::class, 'addBackground'] )->name('addBackground');
        $route->post('/add-header',[ UiController::class, 'addHeader'] )->name('addHeader');

    });

    Route::group(['prefix' => 'marketingChannel', 'as'=>'marketingChannel.'], function($route){
        $route->get('/',[ MarketingChannelController::class, 'index'] )->name('index');
        Route::group(['prefix' => 'discountProduct', 'as'=>'discountProduct.'], function($route){
            $route->get('/',[ MarketingChannelController::class, 'discountProductIndex'] )->name('index');
            $route->any('/add-program',[ MarketingChannelController::class, 'addDiscountProduct'] )->name('addDiscountProduct');

        });
        $route->get('/delete-promotion/{programId}',[ MarketingChannelController::class, 'deleteProgram'] )->name('deleteProgram');

        $route->post('/apply-promotion', [AdminController::class,'applyPromotionForItem'])->name('applyPromotionForItem');
    });
});
