<?php

use App\Http\Controllers\Admin\AdminGroupingController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminShipmentController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

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

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.orders.new');
    })->name('dashboard');

    Route::get('/orders/new', [AdminOrderController::class, 'newOrders'])->name('orders.new');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/confirm', [AdminOrderController::class, 'confirm'])->name('orders.confirm');
    Route::post('/orders/{order}/cancel', [AdminOrderController::class, 'cancel'])->name('orders.cancel');

    Route::get('/scan-grouping', [AdminGroupingController::class, 'index'])->name('grouping');
    Route::post('/scan-grouping/start', [AdminGroupingController::class, 'start'])->name('grouping.start');
    Route::post('/scan-grouping/add', [AdminGroupingController::class, 'add'])->name('grouping.add');
    Route::post('/scan-grouping/remove', [AdminGroupingController::class, 'remove'])->name('grouping.remove');
    Route::post('/scan-grouping/depart', [AdminGroupingController::class, 'depart'])->name('grouping.depart');

    Route::get('/shipments/active', [AdminShipmentController::class, 'active'])->name('shipments.active');
    Route::post('/shipments/{session}/finish', [AdminShipmentController::class, 'finish'])->name('shipments.finish');
    Route::get('/shipments/history', [AdminShipmentController::class, 'history'])->name('shipments.history');
});
