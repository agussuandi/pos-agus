<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{HistoryController, SalesOrderController};
use App\Http\Controllers\Json\{CashierJsonController, ProductJsonController};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [SalesOrderController::class, 'index']);
Route::resource('history', HistoryController::class);
Route::resource('sales-order', SalesOrderController::class);

Route::prefix('json')->name('json.')->group(function () {
    Route::resource('cashier', CashierJsonController::class)->only('show');
    Route::resource('product', ProductJsonController::class)->only('show');
});
