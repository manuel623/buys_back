<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
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

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    //Cerrar sesion
    Route::post('/logout', [AuthController::class, 'logout']);
    
    //Usuarios
    Route::prefix('user')->middleware('auth:api')->group(function () {
        Route::get('/listUser', [UserController::class, 'listUser']);
        Route::post('/createUser', [UserController::class, 'createUser']);
        Route::put('/editUser/{id?}', [UserController::class, 'editUser']);
        Route::delete('/deleteUser/{id?}', [UserController::class, 'deleteUser']);
    });

    //Productos
    Route::prefix('product')->middleware('auth:api')->group(function () {
        Route::get('/listProduct', [ProductController::class, 'listProduct']);
        Route::get('/topPurchasedProducts', [ProductController::class, 'topPurchasedProducts']);
        Route::post('/createProduct', [ProductController::class, 'createProduct']);
        Route::put('/editProduct/{id?}', [ProductController::class, 'updateProduct']);
        Route::patch('/updateStock/{id?}', [ProductController::class, 'updateStock']);
        Route::delete('/deleteProduct/{id?}', [ProductController::class, 'deleteProduct']);
    });

    //Ordenes
    Route::prefix('order')->middleware('auth:api')->group(function () {
        Route::get('/listOrder', [OrderController::class, 'listOrder']);
        Route::post('/createOrder', [OrderController::class, 'createOrder']);
        Route::put('/editOrder/{id?}', [OrderController::class, 'updateOrder']);
        Route::delete('/deleteOrder/{id?}', [OrderController::class, 'deleteOrder']);
    });

    //Detalles Ordenes
    Route::prefix('orderDetail')->middleware('auth:api')->group(function () {
        Route::get('/listOrderDetail', [OrderDetailController::class, 'listOrderDetail']);
        Route::post('/createOrderDetail', [OrderDetailController::class, 'createOrderDetail']);
        Route::put('/editOrderDetail/{id?}', [OrderDetailController::class, 'updateOrderDetail']);
        Route::delete('/deleteOrderDetail/{id?}', [OrderDetailController::class, 'deleteOrderDetail']);
    });

    //Comprador
    Route::prefix('buyer')->middleware('auth:api')->group(function () {
        Route::get('/listBuyer', [BuyerController::class, 'listBuyer']);
        Route::get('/getBuyerByDocument/{document}', [BuyerController::class, 'getBuyerByDocument']);
        Route::post('/createBuyer', [BuyerController::class, 'createBuyer']);
        Route::put('/editBuyer/{id}', [BuyerController::class, 'editBuyer']);
        Route::delete('/deleteBuyer/{phone}', [BuyerController::class, 'deleteBuyer']);
    });

});