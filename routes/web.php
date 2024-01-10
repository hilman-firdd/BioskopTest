<?php

use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Front\ViewController;
use App\Http\Controllers\Front\MyTicketController;
use Illuminate\Support\Facades\Route;

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


Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/', [ViewController::class, 'index']);
    Route::get('/my-ticket', [MyTicketController::class, 'index']);
    
    Route::post('/api/film', [BookingController::class, 'loadFilm']);
    Route::post('/api/order', [BookingController::class, 'createOrder']);
    Route::post('/api/order-update', [BookingController::class, 'updateOrder']);
    Route::post('/api/film-detail', [BookingController::class, 'detailFilm']);
    Route::post('/api/my-ticket', [BookingController::class, 'listOrder']);
});
