<?php

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
Route::get('/', function() {
    return view('pages.onboarding');
});

Route::get('/login', function() {
    return view('pages.login');
})->name('login');

Route::get('/logout', [
    \App\Packages\Authentications\Controllers\AuthController::class,
    'logout'
]);

Route::post('/login', [
    \App\Packages\Authentications\Controllers\AuthController::class,
    'login'
]);

Route::middleware(['auth'])->group(function () {
    Route::get('/test', function () {
        return view('app');
    });
    Route::get('{any}', function () {
        return view('app');
    })->where('any','.*');
});

// Route::get('{any}', function () {
//     abort(404);
// })->where('any','.*');
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
