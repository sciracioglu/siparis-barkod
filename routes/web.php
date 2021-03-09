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
    $info = collect(\Illuminate\Support\Facades\DB::select("EXEC spWebSiparisBarkod ?", [request('barcode')])[0]);
    dd($info);
    return view('welcome');
});


Route::resource('barcode', BarcodeController::class)->only([
    'index', 'store'
]);
