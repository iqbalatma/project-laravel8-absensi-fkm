<?php

use App\Http\Controllers\API\RegistrationCredentialController;
use App\Models\RegistrationCredential;
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

Route::post('/register', [App\Http\Controllers\API\AuthController::class, 'register']);
Route::post('/login', [App\Http\Controllers\API\AuthController::class, 'login']);


Route::name('x')->middleware(['auth:sanctum', 'role:admin,superadmin'])->group(function () {
    Route::prefix('registration-credentials')
        ->controller(RegistrationCredentialController::class)->group(function () {
            Route::post('/', 'store');
            Route::get('/{id}', 'show');
            Route::get('/', 'index');
            Route::post('/{id}', 'update');
        });
});
/**
 * 
 * Tabel credential
 * 
 * id 1
 * token sfsegs
 * role_id 3 anak hima
 * is_active 1
 * 
 * 
 * https://admin.com/register/sfsegs
 * https://admin.com/register/alumni
 * https://admin.com/register/guest
 * 
 * a, b, c
 */
