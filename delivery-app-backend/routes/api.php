<?php 

use App\Http\Controllers\AuthController;
use App\Http\Middleware\GuestMiddleware;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\UserController;

Route::middleware(GuestMiddleware::class)->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
});
Route::middleware(AuthMiddleware::class)->group(function () {
    Route::get('me', [AuthController::class, 'me'])->name('me');
    Route::get('users', [UserController::class, 'index']); // View all drivers
    Route::get('users/{id}', [UserController::class, 'show']); // View one driver
    Route::post('users', [UserController::class, 'store']); // Add a new driver
    Route::post('update_users', [UserController::class, 'update']); // Edit a driver
    Route::delete('users/{id}', [UserController::class, 'destroy']); // Delete a driver

    Route::get('orders', [OrderController::class, 'index']); // View all orders
    Route::get('orders/{id}', [OrderController::class, 'show']); // View one order
    Route::post('orders', [OrderController::class, 'store']); // Add a new order
    Route::put('orders/{id}', [OrderController::class, 'update']); // Edit an order
    Route::delete('orders/{id}', [OrderController::class, 'destroy']); // Delete an order


    Route::get('shops', [ShopController::class, 'index']); // View all shops
    Route::get('shops/{id}', [ShopController::class, 'show']); // View one shop
    Route::post('shops', [ShopController::class, 'store']); // Add a new shop
    Route::post('update_shops', [ShopController::class, 'update']); // Edit a shop
    Route::delete('shops/{id}', [ShopController::class, 'destroy']); // Delete a shop


    Route::get('clients', [ClientController::class, 'index']); // View all clients
    Route::get('clients/{id}', [ClientController::class, 'show']); // View one client
    Route::post('clients', [ClientController::class, 'store']); // Add a new client
    Route::post('update_clients', [ClientController::class, 'update']); // Edit a client
    Route::delete('clients/{id}', [ClientController::class, 'destroy']); // Delete a client

}   );

Route::apiResource('users', UserController::class);