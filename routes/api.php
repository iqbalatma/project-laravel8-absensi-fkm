<?php

use App\Http\Controllers\API\AssetController;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\CheckinController;
use App\Http\Controllers\API\CheckinStatusController;
use App\Http\Controllers\API\CheckinStatusMonitoringController;
use App\Http\Controllers\API\CongressDayController;
use App\Http\Controllers\API\DocumentDownloadController;
use App\Http\Controllers\API\ManualCheckinController;
use App\Http\Controllers\API\ManualRegistrationController;
use App\Http\Controllers\API\OrganizationController;
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





Route::middleware(['auth:api'])->group(function () {
    Route::prefix('download')
        ->controller(DocumentDownloadController::class)->group(function () {
            Route::get('/{id}', 'download');
            Route::get('/congress-draft', 'congressDraft');
            Route::get('/manual-book', 'manualBook');
        });
    Route::prefix('download')
        ->name('download')
        ->controller(AssetController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{id}', 'show')->name('show');
        });
        
    Route::middleware(['role:admin,superadmin'])->group(function (){
        Route::prefix('organizations')
            ->name('organizations.')
            ->controller(OrganizationController::class)
            ->group(function ()
            {
                Route::get('/', 'index')->name('index');
                Route::get('/{id}', 'show')->name('show');
                Route::patch('/{id}', 'update')->name('update');
                Route::post('/', 'store')->name('store');
                Route::delete('/{id}', 'destroy')->name('destroy');
            });
    });

    
    

    Route::post('/checkin-manual', [ManualCheckinController::class, 'manualCheckin'])->name('checkin.manual');  

    Route::post('/register-manual', [ManualRegistrationController::class, 'manualRegistration'])->name('register.manual');    

    Route::prefix('registration-credentials')
        ->controller(RegistrationCredentialController::class)->group(function () {
            Route::post('/', 'store');
            Route::get('/{id}', 'show');
            Route::get('/', 'index');
            Route::patch('/{id}', 'update');
            Route::delete('/{id}', 'destroy');
            Route::get('/token/{token}', 'showByToken');
        });

    Route::prefix('checkin')
        ->controller(CheckinStatusController::class)->group(function () {
            Route::post('/{personal_token}', 'checkin');
            Route::post('/congress-date/{personal_token}', 'checkinByCongressDate');
            Route::get('/', 'index');
        });
    Route::prefix('checkin')
        ->controller(CheckinStatusMonitoringController::class)->group(function () {
            Route::get('/monitoring', 'getSummary');
            Route::get('/latest', 'getLatest');
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

Route::controller(AuthController::class)->group(function (){
    Route::post('/register/{registration_credential}', 'register');
    Route::post('/login', 'login')->name('auth.login');
    Route::post('/logout', 'logout');
    Route::post('/refresh', 'refresh');
    Route::post('/me', 'me');
});

Route::get('registration-credentials/token/{token}', [RegistrationCredentialController::class, 'showByToken']);
