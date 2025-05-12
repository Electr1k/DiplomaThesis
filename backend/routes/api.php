<?php

use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\CabinetController;
use App\Http\Controllers\V1\CourierController;
use App\Http\Controllers\V1\PermissionController;
use App\Http\Controllers\V1\ReportController;
use App\Http\Controllers\V1\RoleController;
use App\Http\Controllers\V1\UserController;
use App\Models\Enums\Permissions\CabinetPermissions;
use App\Models\Enums\Permissions\CourierPermissions;
use App\Models\Enums\Permissions\DashboardPermissions;
use App\Models\Enums\Permissions\PermissionPermissions;
use App\Models\Enums\Permissions\ReportPermissions;
use App\Models\Enums\Permissions\RolePermissions;
use App\Models\Enums\Permissions\UserPermissions;
use App\Models\Role;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')
    ->group(function () {
        Route::prefix('auth')->group(function () {
            Route::post('login', [AuthController::class, 'login']);
            Route::get('refresh', [AuthController::class, 'refresh']);
            Route::get('logout', [AuthController::class, 'logout']);
        });

        Route::middleware('permission:'.PermissionPermissions::READ->value)
            ->apiResource('permissions', PermissionController::class)->only(['index', 'show']);

        Route::middleware('permission:'.RolePermissions::READ->value)
            ->apiResource('roles', RoleController::class)->only(['index', 'show']);

        Route::middleware('permission:'.RolePermissions::STORE->value)
            ->apiResource('roles', RoleController::class)->only(['store']);

        Route::middleware('permission:'.RolePermissions::UPDATE->value)
            ->apiResource('roles', RoleController::class)->only(['update']);

        Route::middleware('permission:'.RolePermissions::DESTROY->value)
            ->apiResource('roles', RoleController::class)->only(['destroy']);

        Route::get('users/get-by-token', [UserController::class, 'getUserByToken']);

        Route::middleware('permission:'.UserPermissions::READ->value)
            ->apiResource('users', UserController::class)->only(['index', 'show']);

        Route::middleware('permission:'.UserPermissions::STORE->value)
            ->apiResource('users', UserController::class)->only(['store']);

        Route::middleware('permission:'.UserPermissions::UPDATE->value)
            ->apiResource('users', UserController::class)->only(['update']);

        Route::middleware('permission:'.RolePermissions::DESTROY->value)
            ->apiResource('users', UserController::class)->only(['destroy']);

        Route::middleware('permission:'.CourierPermissions::READ->value)
            ->get('/couriers/registrations', [CourierController::class, 'registrations']);

        Route::middleware('permission:'.CourierPermissions::READ->value)
            ->get('/couriers/registrations/{registration}', [CourierController::class, 'registrationShow']);

        Route::middleware('permission:'.CourierPermissions::UPDATE->value)
            ->put('/couriers/registrations/{registration}', [CourierController::class, 'registrationUpdate']);

        Route::middleware('permission:'.CourierPermissions::READ->value)
            ->apiResource('couriers', CourierController::class)->only(['index', 'show']);

        Route::middleware('permission:'.CourierPermissions::STORE->value)
            ->apiResource('couriers', CourierController::class)->only(['store']);

        Route::middleware('permission:'.CourierPermissions::READ->value)->
            get('inactive-couriers', [CourierController::class, 'indexInactive']);

        Route::middleware('permission:'.CabinetPermissions::READ->value)
            ->apiResource('cabinets', CabinetController::class)->only(['index', 'show']);

        Route::prefix('/reports')->group(function () {
            Route::middleware('permission:'.ReportPermissions::SUMMARY->value)
                ->get('summary', [ReportController::class, 'indexSummary']);

            Route::prefix('/dashboard')
                ->middleware('permission:'.DashboardPermissions::READ->value)
                ->group(function () {
                    Route::get('/orders', [ReportController::class, 'dashboardOrders']);
                    Route::get('/new-clients', [ReportController::class, 'dashboardNewClients']);
            });
        });

    });
