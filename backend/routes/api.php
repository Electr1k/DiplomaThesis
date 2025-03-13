<?php

use App\Http\Controllers\V1\RoleController;
use App\Models\Enums\Permissions\RolePermissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//});//->middleware('auth:sanctum');

Route::prefix('v1')
    ->group(function () {
        Route:://middleware('permission:'.RolePermissions::READ->value)->
        apiResource('roles', RoleController::class)->only(['index', 'show']);
    });
