<?php

use App\Http\Controllers\API\ApiBranchController;
use App\Http\Controllers\API\ApiDoctorController;
use App\Http\Controllers\API\ApiNotificationController;
use App\Http\Controllers\API\ApiRoleController;
use App\Http\Controllers\API\ApiUserController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->group(function () {

    Route::apiResource('user', ApiUserController::class);

    Route::prefix('notifications')->group(function () {

        Route::prefix('system')->group(function () {
            Route::get('', [ApiNotificationController::class, 'getSystemNotifications'])->name('notifications.getSystem');
            Route::post('/{id}/read', [ApiNotificationController::class, 'markAsReadSystemNotification'])->name('notifications.markReadSystem');
            Route::delete('/{id}', [ApiNotificationController::class, 'deleteSystemNotification'])->name('notifications.deleteSystem');
        });

        Route::prefix('user')->group(function () {
            Route::get('', [ApiNotificationController::class, 'getUserNotifications'])->name('notifications.getUser');
            Route::post('/{id}/read', [ApiNotificationController::class, 'markAsReadUserNotification'])->name('notifications.markReadUser');
            Route::delete('/{id}', [ApiNotificationController::class, 'deleteUserNotification'])->name('notifications.deleteUser');
        });
    });

    Route::prefix('role')->group(function () {
        Route::get('', [ApiRoleController::class, 'getAssignableRoles'])->name('role.assignableRoles');
        Route::post('', [ApiRoleController::class, 'createNewRole'])->name('role.create');
        Route::get('/{id}/permissions', [ApiRoleController::class, 'getRolePermissions'])->name('role.permissions');
        Route::patch('/{id}/permissions', [ApiRoleController::class, 'updateRolePermissions'])->name('role.permissions.update');
    });

    Route::apiResource('branch', ApiBranchController::class);

    Route::prefix('doctor')->group(function () {
        Route::post('/create', [ApiDoctorController::class, 'store']);
        Route::get('/index', [ApiDoctorController::class, 'index']);
        Route::delete('/delete/{id}', [ApiDoctorController::class, 'destroy']);
        Route::patch('/update/{id}', [ApiDoctorController::class, 'update']);
        
    });
});