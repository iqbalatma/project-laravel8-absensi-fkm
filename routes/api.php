<?php

use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\CheckinController;
use App\Http\Controllers\API\CheckinStatusController;
use App\Http\Controllers\API\CongressDayController;
use App\Http\Controllers\API\RegistrationCredentialController;
use App\Http\Controllers\API\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::post('/register/{token}', [App\Http\Controllers\API\AuthController::class, 'register']);
// Route::post('/login', [App\Http\Controllers\API\AuthController::class, 'login']);


Route::controller(AuthController::class)->group(function (){
    Route::post('/register/{registration_credential}', 'register');
    Route::post('/login', 'login')->name('auth.login');
    Route::post('/logout', 'logout');
});

Route::middleware(['auth:api', 'role:admin,superadmin'])->group(function () {
    Route::prefix('registration-credentials')
        ->controller(RegistrationCredentialController::class)->group(function () {
            Route::post('/', 'store');
            Route::get('/{id}', 'show');
            Route::get('/', 'index');
            Route::patch('/{id}', 'update');
            Route::delete('/{id}', 'destroy');
        });

    Route::prefix('checkin')
        ->controller(CheckinStatusController::class)->group(function () {
            Route::post('/{personal_token}', 'checkin');
            Route::get('/', 'index');
        });
    Route::prefix('congress-day')
        ->controller(CongressDayController::class)->group(function () {
            Route::post('/', 'store');
            Route::get('/{id}', 'show');
            Route::get('/', 'index');
            Route::patch('/{id}', 'update');
            Route::delete('/{id}', 'destroy');
        });

  
});

Route::middleware(['auth:api', 'role:superadmin'])->group(function () {
    Route::prefix('users')
    ->controller(UserController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::patch('/{id}', 'update');
    });
});
