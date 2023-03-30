<?php

use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\ObjectVersionController;
use App\Http\Controllers\Api\V1\TransactionController;
use App\Http\Controllers\ReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//v1
use App\Http\Controllers\Api\V1\AuthController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:api'])->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('transactions', TransactionController::class);
    Route::get('deleted-transaction-ids', [TransactionController::class,'deletedTransactions']);
    Route::get('deleted-category-ids', [CategoryController::class,'deletedCategories']);

    Route::post('categories/changes', [ObjectVersionController::class,'getChangedCategories']);
    Route::post('transactions/changes', [ObjectVersionController::class,'getChangedTransactions']);

    Route::post('batch-objects', [ObjectVersionController::class,'storeBatch']);

    Route::patch('/users', [AuthController::class, 'update']);
    Route::post('/users/profile', [AuthController::class, 'updateProfileImage']);
    Route::get('/users', [AuthController::class, 'get']);


});
Route::get('unauthenticated',function(){
    return response()->json(["error"=>"You are not allowed to access this."],403);
})->name('unauthenticated');

Route::get('/get-access-token/{googleIdToken}', [AuthController::class, 'getAccessToken']);
Route::post('/reporting', [ReportController::class, 'exportPDF']);
