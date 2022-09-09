<?php

use App\Http\Controllers\API\CheckinController;
use App\Http\Controllers\API\CheckinStatusController;
use App\Http\Controllers\API\CongressDayController;
use App\Http\Controllers\API\RegistrationCredentialController;
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

Route::post('/register/{token}', [App\Http\Controllers\API\AuthController::class, 'register']);
Route::post('/login', [App\Http\Controllers\API\AuthController::class, 'login']);


Route::name('x')->middleware(['auth:sanctum', 'role:admin,superadmin'])->group(function () {
    Route::prefix('registration-credentials')
        ->controller(RegistrationCredentialController::class)->group(function () {
            Route::post('/', 'store');
            Route::get('/{id}', 'show');
            Route::get('/', 'index');
            Route::put('/{id}', 'update');
        });

    Route::prefix('checkin')
        ->controller(CheckinStatusController::class)->group(function () {
            Route::post('/{personal_token}', 'checkin');
        });

    Route::prefix('congress-day')
        ->controller(CongressDayController::class)->group(function () {
            Route::post('/', 'store');
            Route::get('/{id}', 'show');
            Route::get('/', 'index');
            Route::put('/{id}', 'update');
        });
});
