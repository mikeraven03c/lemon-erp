<?php

use App\Packages\Users\Controllers\UserController;
use App\Packages\VirtualAttributes\Controllers\VirtualAttributeController;
use App\Packages\VirtualGroups\Controllers\VirtualGroupController;
use App\Packages\VirtualModels\Controllers\VirtualModelController;
use App\Packages\VirtualModels\Controllers\VirtualResourceController;
use App\Packages\VirtualResources\Contracts\VirtualResourceContract;
use Illuminate\Support\Facades\Route;

$middleware = env('APP_ENV', 'local') == 'local'
    ? []
    : ['auth'];
Route::middleware($middleware)->group(function() {
    Route::get('/auth', [
        \App\Packages\Authentications\Controllers\AuthController::class,
        'getAuth'
    ]);

    Route::post('user/delete', [UserController::class, 'destroy']);
    Route::apiResources([
        'user' => UserController::class
    ]);

    Route::get('virtual-attribute/select/{select}', [
        VirtualAttributeController::class, 'getVModelSelectSSR'
    ]);

    Route::get('virtual-attribute/attribute/{select}', [
        VirtualAttributeController::class, 'getSelectVAttribute'
    ]);

    Route::post('virtual-attribute/get-index-data', [VirtualAttributeController::class, 'getIndexData']);
    Route::post('virtual-attribute/get-table-data', [VirtualAttributeController::class, 'getData']);
    Route::post('virtual-attribute/delete', [VirtualAttributeController::class, 'destroy']);
    Route::apiResources([
        'virtual-attribute' => VirtualAttributeController::class
    ]);
    Route::post('virtual-group/delete', [VirtualGroupController::class, 'destroy']);
    Route::apiResources([
        'virtual-group' => VirtualGroupController::class
    ]);

    Route::post('virtual-model/delete', [VirtualModelController::class, 'destroy']);
    Route::apiResources([
        'virtual-model' => VirtualModelController::class
    ]);

    // Route::get('app/model/{endpoint}/select/{name}', []);

    Route::get('app/resource/{endpoint}/index', [VirtualResourceController::class, 'getIndexData']);
    Route::get('app/resource/{endpoint}/data', [VirtualResourceController::class, 'getTableData']);
    Route::post('app/resource/{endpoint}', [VirtualResourceController::class, 'store']);
    Route::put('app/resource/{endpoint}/{id}', [VirtualResourceController::class, 'update']);
    Route::post('app/resource/{endpoint}/delete', [VirtualResourceController::class, 'destroy']);
});
