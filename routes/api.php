<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\customer\CustomerController;
use App\Http\Controllers\menu\MenuController;
use App\Http\Controllers\order\OrderController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;


Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login'])->name('login');

//

Route::group(['middleware' => ['auth:sanctum', 'role:admin']], function() {
    Route::post('/admin/assign-role/{userId}', [RoleController::class, 'assignRole']);
    Route::get('/admin/dashboard', [AdminController::class, 'index']);
    Route::get('/admin/get-customers', [AdminController::class, 'getAllCustomers']);
    Route::post('/admin/logout', [AuthController::class, 'logout']);
    Route::apiResource('users', UserController::class);
});

Route::group(['middleware' => ['auth:sanctum', 'role:customer']], function() {
    Route::get('/dashboard', [CustomerController::class, 'index']);
    Route::get('/menu/top-pick', [MenuController::class, 'topPick']);
    Route::get('/menu/meals', [MenuController::class, 'meals']);
    Route::get('/menu/drinks', [MenuController::class, 'drinks']);
    Route::get('/menu/shawarma', [MenuController::class, 'shawarma']);
    Route::get('/orders/active', [OrderController::class, 'activeOrders']);
    //orders
    Route::apiResource('orders',OrderController::class);
    Route::post('/logout', [AuthController::class, 'logout']);
});
