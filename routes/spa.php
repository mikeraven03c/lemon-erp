<?php

use App\Packages\Users\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/auth', [
    \App\Packages\Authentications\Controllers\AuthController::class,
    'getAuth'
]);

$middleware = env('APP_ENV', 'local') == 'local'
    ? []
    : ['auth'];
Route::middleware($middleware)->group(function() {
    Route::post('user/delete', [UserController::class, 'destroy']);
    Route::apiResources([
        'user' => UserController::class
    ]);
});
