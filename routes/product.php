<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;



Route::group(['prefix' => 'product', 'as'=>'product.'], function($route){
    $route->any('/{productId}', [ProductController::class, 'index'])->name('index');

    Route::group(['prefix' => 'item', 'as'=>'item.'], function($route){
        $route->get('/{productItemId}', [ ProductController::class, 'productItem'])->name('productItem');

    });

});
