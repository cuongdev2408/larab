<?php

use CuongDev\Larab\Abstraction\Definition\DefineRole;
use CuongDev\Larab\Abstraction\Definition\DefineRoute;
use CuongDev\Larab\App\Http\Controllers\Api\ACL\PermissionController;
use CuongDev\Larab\App\Http\Controllers\Api\ACL\PermissionGroupController;
use CuongDev\Larab\App\Http\Controllers\Api\ACL\RoleController;
use CuongDev\Larab\App\Http\Controllers\Api\AuthController;
use CuongDev\Larab\App\Http\Controllers\Api\UserController;
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

Route::group(['prefix' => 'api', 'middleware' => 'api', 'namespace' => 'CuongDev\Larab\App\Http\Controllers'], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', [AuthController::class, 'login'])
            ->name(DefineRoute::API_AUTH_LOGIN);

        Route::group(['middleware' => 'auth.jwt'], function () {
            Route::post('logout', [AuthController::class, 'logout'])
                ->name(DefineRoute::API_AUTH_LOGOUT);
            Route::post('refresh', [AuthController::class, 'refresh'])
                ->name(DefineRoute::API_AUTH_REFRESH);
            Route::post('me', [AuthController::class, 'me'])
                ->name(DefineRoute::API_AUTH_ME);
            Route::post('update', [AuthController::class, 'update'])
                ->name(DefineRoute::API_AUTH_UPDATE);
        });
    });

    Route::group(['middleware' => ['auth.jwt', 'role:' . DefineRole::SUPER_ADMINISTRATOR]], function () {
        /**
         * User
         */
        Route::group(['prefix' => 'users'], function () {
            Route::get('/', [UserController::class, 'getList'])
                ->name(DefineRoute::API_USER_LIST);
            Route::get('/find-one', [UserController::class, 'findOne'])
                ->name(DefineRoute::API_USER_FIND_ONE);
            Route::get('/{id}', [UserController::class, 'getOne'])
                ->name(DefineRoute::API_USER_DETAIL);
            Route::post('/', [UserController::class, 'create'])
                ->name(DefineRoute::API_USER_CREATE);
            Route::put('/{id}', [UserController::class, 'update'])
                ->name(DefineRoute::API_USER_UPDATE);
            Route::delete('/{id}', [UserController::class, 'delete'])
                ->name(DefineRoute::API_USER_DELETE);

            Route::post('/sync-roles', [UserController::class, 'syncRoles'])
                ->name(DefineRoute::API_USER_SYNC_ROLES);
            Route::post('/sync-permissions', [UserController::class, 'syncPermissions'])
                ->name(DefineRoute::API_USER_SYNC_PERMISSIONS);
        });

        /**
         * Role
         */
        Route::group(['prefix' => 'roles'], function () {
            Route::get('/', [RoleController::class, 'getList'])
                ->name(DefineRoute::API_ROLE_LIST);
            Route::get('/{id}', [RoleController::class, 'getOne'])
                ->name(DefineRoute::API_ROLE_DETAIL);
            Route::post('/', [RoleController::class, 'create'])
                ->name(DefineRoute::API_ROLE_CREATE);
            Route::put('/{id}', [RoleController::class, 'update'])
                ->name(DefineRoute::API_ROLE_UPDATE);
            Route::delete('/{id}', [RoleController::class, 'delete'])
                ->name(DefineRoute::API_ROLE_DELETE);

            Route::post('/sync-permissions', [RoleController::class, 'syncPermissions'])
                ->name(DefineRoute::API_ROLE_SYNC_PERMISSIONS);
        });

        /**
         * Permission Group
         */
        Route::group(['prefix' => 'permission-groups'], function () {
            Route::get('/', [PermissionGroupController::class, 'getList'])
                ->name(DefineRoute::API_PERMISSION_GROUP_LIST);
            Route::get('/{id}', [PermissionGroupController::class, 'getOne'])
                ->name(DefineRoute::API_PERMISSION_GROUP_DETAIL);
            Route::post('/', [PermissionGroupController::class, 'create'])
                ->name(DefineRoute::API_PERMISSION_GROUP_CREATE);
            Route::put('/{id}', [PermissionGroupController::class, 'update'])
                ->name(DefineRoute::API_PERMISSION_GROUP_UPDATE);
            Route::delete('/{id}', [PermissionGroupController::class, 'delete'])
                ->name(DefineRoute::API_PERMISSION_GROUP_DELETE);
        });

        /**
         * Permission
         */
        Route::group(['prefix' => 'permissions'], function () {
            Route::get('/', [PermissionController::class, 'getList'])
                ->name(DefineRoute::API_PERMISSION_LIST);
            Route::get('/{id}', [PermissionController::class, 'getOne'])
                ->name(DefineRoute::API_PERMISSION_DETAIL);
            Route::post('/', [PermissionController::class, 'create'])
                ->name(DefineRoute::API_PERMISSION_CREATE);
            Route::put('/{id}', [PermissionController::class, 'update'])
                ->name(DefineRoute::API_PERMISSION_UPDATE);
            Route::delete('/{id}', [PermissionController::class, 'delete'])
                ->name(DefineRoute::API_PERMISSION_DELETE);
        });
    });
});


