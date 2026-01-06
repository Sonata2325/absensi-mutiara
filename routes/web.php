<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/home', [PageController::class, 'home']);
// Route::get('/tentang-kami', [PageController::class, 'about'])->name('about');
// Route::get('/about', [PageController::class, 'about']);
Route::get('/layanan', [PageController::class, 'services'])->name('services');
Route::get('/services', [PageController::class, 'services']);

Route::get('/lacak', [PageController::class, 'tracking'])->name('tracking');
Route::get('/tracking', [PageController::class, 'tracking']);

Route::get('/pesan', [PageController::class, 'order'])->name('order');
Route::get('/order', [PageController::class, 'order']);
Route::post('/order', [PageController::class, 'submitOrder'])->name('order.submit');

Route::get('/order/success', [PageController::class, 'orderSuccess'])->name('order.success');
Route::get('/pesan/sukses', [PageController::class, 'orderSuccess']);

Route::get('/kontak', [PageController::class, 'contact'])->name('contact');
Route::get('/contact', [PageController::class, 'contact']);
Route::post('/contact', [PageController::class, 'submitContact'])->name('contact.submit');
