<?php

use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\Auth\AuthController;

use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [AuthController::class, 'index']);
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/post-login', [AuthController::class, 'postLogin'])->name('login.post'); 
Route::get('/registration', [AuthController::class, 'registration'])->name('register');
Route::post('/post-registration', [AuthController::class, 'postRegistration'])->name('register.post'); 
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function(){
    Route::resource('products', ProductController::class); 

    Route::get('/payment/{string}/{price}', [ProductController::class, 'charge'])->name('goToPayment');
    Route::get('/product-detail/{id}', [ProductController::class, 'productDetail'])->name('product');
    Route::get('payment-successful', [ProductController::class, 'paymentComplete']);
    Route::post('payment/process-payment/{string}/{price}', [ProductController::class, 'processPayment'])->name('processPayment');
});
