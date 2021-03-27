<?php

use App\Http\Controllers\BarcodeController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {

    return view('welcome');
});


Route::get('/barcode', [BarcodeController::class, 'index']);
Route::post('/barcode', [BarcodeController::class, 'store']);
Route::get('/palet-list', [BarcodeController::class,'show']);
Route::delete('/barcode-delete/{evrak_no}/{lot_no}', [BarcodeController::class,'destroy']);
