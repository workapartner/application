<?php

use App\Http\Controllers\Api\CompanySymbolController;
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
Route::get('/get-symbol', [CompanySymbolController::class, 'symbol'])->name('symbol.get');
Route::get('/symbol', [CompanySymbolController::class, 'index']);
Route::get('/show', [CompanySymbolController::class, 'show']);
Route::get('/send', [CompanySymbolController::class, 'send']);
