<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PdfGeneratorController;
use App\Http\Controllers\TestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
require_once 'admin.php';
require_once 'product.php';
require_once 'invoice.php';

Auth::routes();
Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/test-qr-scanner', function(){
    return view('testQrScanner');
})->name('testQrScanner');

Route::get('/test-algorithm', [TestController::class, 'testAlgorithm']);
Route::get('/test', function(){
    return view('test');
})->name('test');
