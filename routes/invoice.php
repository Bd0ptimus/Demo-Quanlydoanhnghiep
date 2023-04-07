<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;



Route::group(['prefix' => 'invoice', 'as'=>'invoice.'], function($route){
    $route->any('/{invoiceId}', [AdminController::class, 'showInvoice'])->name('showInvoice');


});
