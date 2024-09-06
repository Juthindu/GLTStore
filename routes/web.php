<?php
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TeaTypeController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::prefix('user')->group(function () {
        Route::get('', [UserController::class, 'index'])->name('user.index');
        Route::get('/create', [UserController::class, 'create'])->name('user.create');
        Route::get('/me', [UserController::class, 'profile'])->name('user.profile');
    });

    Route::prefix('permission')->group(function () {
        Route::get('', [PermissionController::class, 'index'])->name('permission.index');
        Route::get('/{id}', [PermissionController::class, 'show'])->name('permission.show');
    });

    Route::get('branch', [BranchController::class, 'create'])->name('branch.create');
    Route::get('branch-view', [BranchController::class, 'index'])->name('branch.index');

    Route::prefix('notifications')->group(function () {
        Route::get('user', [NotificationController::class, 'showUserNotification'])->name('user.notifications');
        Route::get('system', [NotificationController::class, 'showSystemNotifications'])->name('system.notifications');
    });

    Route::prefix('inventory')->group(function () {
        Route::get('', [InventoryController::class, 'index'])->name('inventory.manage');
        Route::get('/create', [InventoryController::class, 'create'])->name('inventory.create');
        Route::get('/adjust', [InventoryController::class, 'adjust'])->name('inventory.adjust');
    });

    Route::prefix('orders')->group(function () {
        Route::get('', [OrderController::class, 'index'])->name('orders.manage');
        Route::get('/create', [OrderController::class, 'create'])->name('orders.create');
        Route::get('/status', [OrderController::class, 'status'])->name('orders.status');
    });

    Route::prefix('customers')->group(function () {
        Route::get('', [CustomerController::class, 'index'])->name('customers.manage');
        Route::get('/create', [CustomerController::class, 'create'])->name('customers.create');
        Route::get('/update', [CustomerController::class, 'update'])->name('customers.update');
    });

    Route::prefix('tea-types')->group(function () {
        Route::get('', [TeaTypeController::class, 'index'])->name('tea_types.view');
        Route::get('/create', [TeaTypeController::class, 'create'])->name('tea_types.create');
        Route::get('/update', [TeaTypeController::class, 'update'])->name('tea_types.update');

    });

});
