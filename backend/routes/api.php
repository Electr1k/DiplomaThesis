<?php

use App\Http\Controllers\V1\PermissionController;
use App\Http\Controllers\V1\RoleController;
use App\Http\Controllers\V1\UserController;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')
    ->group(function () {
        Route:://middleware('permission:'.RolePermissions::READ->value)->
        apiResource('roles', RoleController::class)->only(['index', 'show']);

        Route:://middleware('permission:'.RolePermissions::READ->value)->
        apiResource('permissions', PermissionController::class)->only(['index', 'show']);

        Route:://middleware('permission:'.RolePermissions::READ->value)->
        apiResource('users', UserController::class)->only(['index', 'show']);

    });
