<?php

use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\CabinetController;
use App\Http\Controllers\V1\CourierController;
use App\Http\Controllers\V1\PermissionController;
use App\Http\Controllers\V1\RoleController;
use App\Http\Controllers\V1\UserController;
use App\Models\Enums\Permissions\CourierPermissions;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->middleware('auth:api')
    ->group(function () {
        Route::prefix('auth')->group(function () {
            Route::post('login', [AuthController::class, 'login'])->withoutMiddleware('auth:api');
            Route::post('refresh', [AuthController::class, 'refresh'])->withoutMiddleware('auth:api');
            Route::get('logout', [AuthController::class, 'logout']);
        });

        Route:://middleware('permission:'.RolePermissions::READ->value)->
        apiResource('permissions', PermissionController::class)->only(['index', 'show']);

        Route:://middleware('permission:'.RolePermissions::READ->value)->
        apiResource('roles', RoleController::class)->only(['index', 'show']);

        Route:://middleware('permission:'.RolePermissions::STORE->value)->
        apiResource('roles', RoleController::class)->only(['store']);

        Route:://middleware('permission:'.RolePermissions::UPDATE->value)->
        apiResource('roles', RoleController::class)->only(['update']);

        Route:://middleware('permission:'.RolePermissions::STORE->value)->
        apiResource('roles', RoleController::class)->only(['destroy']);

        Route:://middleware('permission:'.RolePermissions::READ->value)->
        apiResource('users', UserController::class)->only(['index', 'show']);

        Route:://middleware('permission:'.RolePermissions::READ->value)->
        apiResource('users', UserController::class)->only(['store']);

        Route:://middleware('permission:'.RolePermissions::READ->value)->
        apiResource('users', UserController::class)->only(['update']);

        Route:://middleware('permission:'.RolePermissions::READ->value)->
        apiResource('users', UserController::class)->only(['destroy']);

        Route:://middleware('permission:'.RolePermissions::DESTROY->value)->
        apiResource('users', UserController::class)->only(['destroy']);

        Route:://middleware('permission:'.CourierPermissions::READ->value)->
        get('/couriers/registrations', [CourierController::class, 'registrations']);

        Route:://middleware('permission:'.CourierPermissions::READ->value)->
        apiResource('couriers', CourierController::class)->only(['index', 'show']);

        Route:://middleware('permission:'.CourierPermissions::READ->value)->
        apiResource('couriers', CourierController::class)->only(['store']);

        Route:://middleware('permission:'.CourierPermissions::READ->value)->
        apiResource('cabinets', CabinetController::class)->only(['index', 'show']);

        Route:://middleware('permission:'.CourierPermissions::READ->value)->
        get('/test', function (\App\Repositories\OrdersRepository $orders) {
           dd( $orders->getAll()->first()->order_status);

            return response()->json($orders->getAll()->first()->toArray());
        });

    });
