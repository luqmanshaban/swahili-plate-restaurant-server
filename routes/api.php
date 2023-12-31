<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\AdminProfilePictureController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\UserOrdersController;
use App\Http\Controllers\AllMenusController;
use App\Http\Controllers\admin\AdminDetailsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\customer\CustomerController;
use App\Http\Controllers\customer\CustomerDetailsController;
use App\Http\Controllers\customer\CustomerProfilePictureController;
use App\Http\Controllers\menu\AdminMenuController;
use App\Http\Controllers\menu\MenuController;
use App\Http\Controllers\order\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\user\MessageController;
use App\Http\Controllers\admin\MessagesController as Messages;
use Illuminate\Support\Facades\Route;


Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::apiResource('menus', AllMenusController::class);

Route::get('/menu/top-pick', [MenuController::class, 'topPick']);
Route::get('/menu/meals', [MenuController::class, 'meals']);
Route::get('/menu/drinks', [MenuController::class, 'drinks']);
Route::get('/menu/shawarma', [MenuController::class, 'shawarma']);
//

Route::group(['middleware' => ['auth:sanctum', 'role:admin']], function() {
    Route::post('/admin/assign-role/{userId}', [RoleController::class, 'assignRole']);
    Route::get('/admin/dashboard', [AdminController::class, 'index']);
    Route::get('/admin/get-customers', [AdminController::class, 'getAllCustomers']);
    Route::apiResource('admin-details', AdminDetailsController::class);
    Route::apiResource('profiles', AdminProfilePictureController::class);
    Route::apiResource('users', UserController::class);
    Route::apiResource('menus', AdminMenuController::class);
    Route::apiResource('user-orders', UserOrdersController::class);
    Route::get('previous-orders', [UserOrdersController::class, 'getLastPreviousOrders']);
    Route::put('/user-orders/{id}', [UserOrdersController::class, 'update']);            
    Route::get('/order-history', [UserOrdersController::class, 'history']);            
    Route::put('/admin/menus/{id}', [AdminMenuController::class, 'update']);
    Route::delete('/admin/menus/{id}', [AdminMenuController::class, 'destroy']);
    Route::get('admin/messages', [Messages::class, 'getActiveMessages']);
    Route::post('/admin/logout', [AuthController::class, 'logout']);
});

Route::group(['middleware' => ['auth:sanctum', 'role:customer']], function() {
    Route::get('/dashboard', [CustomerController::class, 'index']);
    Route::apiResource('payments', PaymentController::class);
    //orders
    Route::get('/orders/active', [OrderController::class, 'activeOrders']);
    Route::post('/order-status', [PaymentController::class, 'confirmPayment']);
    Route::put('update-order/{id}', [OrderController::class, 'update']);
    Route::put('cancel-order/{id}', [OrderController::class, 'cancelOrder']);
    Route::apiResource('orders', OrderController::class);
    //
    Route::apiResource('customer-profile-pictures', CustomerProfilePictureController::class);
    Route::apiResource('customer-details', CustomerDetailsController::class);
    Route::post('/messages', [MessageController::class, 'createMessage']);
    Route::get('/messages', [MessageController::class, 'getMessages']);
    //
    Route::post('/user/logout', [AuthController::class, 'logout']);
});
