<?php 
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\GuestMiddleware;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DriverController;

Route::middleware(GuestMiddleware::class)->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
});
Route::middleware(AuthMiddleware::class)->group(function () {
    Route::get('me', [AuthController::class, 'me'])->name('me');
    Route::get('drivers', [DriverController::class, 'index']); // View all drivers
    Route::get('drivers/{id}', [DriverController::class, 'show']); // View one driver
    Route::post('drivers', [DriverController::class, 'store']); // Add a new driver
    Route::put('drivers/{id}', [DriverController::class, 'update']); // Edit a driver
    Route::delete('drivers/{id}', [DriverController::class, 'destroy']); // Delete a driver

Route::get('orders', [OrderController::class, 'index']); // View all orders
Route::get('orders/{id}', [OrderController::class, 'show']); // View one order
Route::post('orders', [OrderController::class, 'store']); // Add a new order
Route::put('orders/{id}', [OrderController::class, 'update']); // Edit an order
Route::delete('orders/{id}', [OrderController::class, 'destroy']); // Delete an order


}   );

Route::apiResource('users', UserController::class);