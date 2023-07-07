<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\customer\CustomerController;
use App\Http\Controllers\manager\ManagerController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;


Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::post('/assign-role/{userId}', [RoleController::class, 'assignRole']);

//
Route::group(['middleware' => ['auth:sanctum', 'role:admin']], function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index']);
});

Route::group(['middleware' => ['auth:sanctum', 'role:customer']], function() {
    Route::get('/dashboard', [CustomerController::class, 'index']);
});

Route::group(['middleware' => ['auth:sanctum', 'role:manager']], function() {
    Route::get('/manager/dashboard', [ManagerController::class, 'index']);
});


