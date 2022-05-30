<?php

use App\Http\Controllers\AuthApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/user/register', [AuthApiController::class, 'register']);
Route::post('/user/sign-in', [AuthApiController::class, 'login']);
Route::post('forgot-password', [\App\Http\Controllers\Api\ResetPasswordController::class, 'forgotPassword']);
Route::post('reset-password', [\App\Http\Controllers\Api\ResetPasswordController::class, 'reset']);

Route::middleware('auth:sanctum')->group(function () {
//Route::middleware('auth_api')->group(function () {
    Route::post('/user/logout', [AuthApiController::class, 'logout']);
    Route::get('/user/list', [AuthApiController::class, 'all']);
    Route::apiResources([
        'companies' => \App\Http\Controllers\Api\CompanyController::class
    ]);
});


