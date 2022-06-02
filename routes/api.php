<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CostumerController;
use App\Http\Controllers\SalesPersonController;
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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);
Route::get('checkAuthToken', [AuthController::class, 'checkToken']);

Route::get('/costumers', [CostumerController::class, 'index']);
Route::prefix('/costumer')->group( function (){
        Route::post('/store', [CostumerController::class, 'store']);
        Route::get('/{id}', [CostumerController::class, 'get']);
        Route::put('/{id}', [CostumerController::class, 'update']);
        Route::delete('/{id}', [CostumerController::class, 'destroy']);

});

Route::prefix('/contact')->group( function (){
    Route::post('/store', [ContactController::class, 'store']);
    Route::get('/{id}', [ContactController::class, 'get']);
    Route::get('/listBySeller/{id}', [ContactController::class, 'listBySeler']);
    Route::put('/{id}', [ContactController::class, 'update']);
    Route::delete('/{id}', [ContactController::class, 'destroy']);
    Route::post('/changeInteractions',[ContactController::class, 'changeInteractions']);

});

Route::prefix('/salesPerson')->group( function (){
    Route::post('/store', [SalesPersonController::class, 'store']);
    Route::get('/{id}', [SalesPersonController::class, 'get']);
    Route::delete('/{id}', [SalesPersonController::class, 'destroy']);

});
