<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\customer\CustomerController;
use App\Http\Controllers\manager\ManagerController;
use App\Http\Controllers\menu\MenuController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;


Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::post('/assign-role/{userId}', [RoleController::class, 'assignRole']);

//
Route::group(['middleware' => ['auth:sanctum', 'role:admin']], function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index']);
    Route::get('/menu/top-pick', [MenuController::class, 'topPick']);
    Route::get('/menu/meals', [MenuController::class, 'meals']);
    Route::get('/menu/drinks', [MenuController::class, 'drinks']);
    Route::get('/menu/shawarma', [MenuController::class, 'shawarma']);
});

Route::group(['middleware' => ['auth:sanctum', 'role:customer']], function() {
    Route::get('/dashboard', [CustomerController::class, 'index']);
    Route::get('/menu/top-pick', [MenuController::class, 'topPick']);
    Route::get('/menu/meals', [MenuController::class, 'meals']);
    Route::get('/menu/drinks', [MenuController::class, 'drinks']);
    Route::get('/menu/shawarma', [MenuController::class, 'shawarma']);
});

Route::group(['middleware' => ['auth:sanctum', 'role:manager']], function() {
    Route::get('/manager/dashboard', [ManagerController::class, 'index']);
    Route::get('/menu/top-pick', [MenuController::class, 'topPick']);
    Route::get('/menu/meals', [MenuController::class, 'meals']);
    Route::get('/menu/drinks', [MenuController::class, 'drinks']);
    Route::get('/menu/shawarma', [MenuController::class, 'shawarma']);
});
