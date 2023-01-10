<?php

use App\Http\Controllers\API\AssetController;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\CheckinStatusMonitoringController;
use App\Http\Controllers\API\DocumentDownloadController;
use App\Http\Controllers\API\ManualCheckinController;
use App\Http\Controllers\API\ManualRegistrationController;
use App\Http\Controllers\API\OrganizierNotificationController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\v1\AssetController as V1AssetController;
use App\Http\Controllers\API\v1\Auth\AuthController as AuthAuthController;
use App\Http\Controllers\API\v1\Auth\RegistrationController;
use App\Http\Controllers\API\v1\CheckinController;
use App\Http\Controllers\API\v1\CheckinStatusController;
use App\Http\Controllers\API\v1\CheckoutAllUserController;
use App\Http\Controllers\API\v1\CongressDayController;
use App\Http\Controllers\API\v1\MonitoringController;
use App\Http\Controllers\API\v1\OrganizationController;
use App\Http\Controllers\API\v1\OrganizerNotificationController;
use App\Http\Controllers\API\v1\RegistrationCredentialController;
use App\Http\Controllers\API\v1\UserManagementController;
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


Route::prefix("/v1")
    ->group(function () {
        Route::controller(AuthAuthController::class)
            ->group(
                function () {
                    Route::post("/login", "authenticate")->name("login");
                    Route::post("/logout", "logout")->name("logout");
                }
            );

        Route::middleware("auth:api")->group(
            function () {
                Route::controller(V1AssetController::class)
                    ->prefix("/assets")
                    ->name("assets.")
                    ->group(
                        function () {
                            Route::get("/", "index")->name("index");
                            Route::get("/{id}", "show")->name("show");
                            Route::get("/download/{id}", "download")->name("download");
                        }
                    );

                Route::controller(OrganizationController::class)
                    ->prefix("/organizations")
                    ->name("organizations.")
                    ->group(
                        function () {
                            Route::get("/", "index")->name("index");
                            Route::get("/{id}", "show")->name("show");
                            Route::post("/", "store")->name("store");
                            Route::put("/{id}", "update")->name("update");
                            Route::delete("/{id}", "destroy")->name("destroy");
                        }
                    );

                Route::controller(CongressDayController::class)
                    ->prefix("/congress-days")
                    ->name("congress.days.")
                    ->group(
                        function () {
                            Route::get("/", "index")->name("index");
                            Route::get("/{id}", "show")->name("show");
                            Route::post("/", "store")->name("store");
                            Route::put("/{id}", "update")->name("update");
                            Route::delete("/{id}", "destroy")->name("destroy");
                        }
                    );

                Route::controller(RegistrationCredentialController::class)
                    ->prefix("/registration-credentials")
                    ->name("registration.credentials.")
                    ->group(
                        function () {
                            Route::get("/", "index")->name("index");
                            Route::get("/{id}", "show")->name("show");
                            Route::get("/token/{token}", "showByToken")->name("showByToken");
                            Route::post("/", "store")->name("store");
                            Route::put("/{id}", "update")->name("update");
                            Route::delete("/{id}", "destroy")->name("destroy");
                        }
                    );

                Route::controller(RegistrationController::class)
                    ->prefix("/registration")
                    ->name("registration.")
                    ->group(function () {
                        Route::post("/credential/{credential}", "registrationWithCredential")->name("registrationWithCredential");
                        Route::post("/", "registration")->name("registration");
                    });


                Route::controller(OrganizerNotificationController::class)
                    ->prefix("/organizer-notifications")
                    ->name("organizer.notifications.")
                    ->group(function () {
                        Route::get("/", "index")->name("index");
                        Route::get("/latest", "latest")->name("latest");
                        Route::post("/", "store")->name("store");
                    });

                Route::controller(CheckinController::class)
                    ->prefix("/checkin")
                    ->name("checkin.")
                    ->group(
                        function () {
                            Route::post("/manual", "checkinManual")->name("checkinManual");
                            Route::post("/{personalToken}", "checkin")->name("checkin");
                        }
                    );

                Route::controller(CheckoutAllUserController::class)
                    ->prefix("/checkout-all-users")
                    ->name("checkout.all.users.")
                    ->group(
                        function () {
                            Route::post("/", "checkoutAllUser");
                        }
                    );
                Route::controller(CheckinStatusController::class)
                    ->prefix("/checkin-statuses")
                    ->name("checkin.statuses.")
                    ->group(
                        function () {
                            Route::get("/", "index")->name("index");
                            Route::get("/latest", "latest")->name("latest");
                        }
                    );

                Route::controller(MonitoringController::class)
                    ->prefix("/monitoring")
                    ->name("monitoring.")
                    ->group(
                        function () {
                            Route::get("/", "index")->name("index");
                        }
                    );

                Route::controller(UserManagementController::class)
                    ->prefix("/users")
                    ->name("users.")
                    ->group(
                        function () {
                            Route::get("/", "index")->name("index");
                            Route::get("/{id}", "show")->name("show");
                            Route::post("/", "store")->name("store");
                        }
                    );
            }
        );
    });





Route::middleware(['auth:api'])->group(function () {
    Route::middleware(['role:admin,superadmin'])->group(function () {

        Route::post(
            '/notifications',
            [OrganizierNotificationController::class, 'store']
        )->name('notifications.store');



        Route::post(
            '/register/manual',
            [AuthController::class, 'registerManual']
        )->name('auth.registerManual');
    });

    /** not admin access required */
    Route::post(
        '/checkin-manual',
        [ManualCheckinController::class, 'manualCheckin']
    )->name('checkin.manual');

    Route::post(
        '/register-manual',
        [ManualRegistrationController::class, 'manualRegistration']
    )->name('register.manual');


    Route::prefix('checkin')
        ->controller(CheckinStatusMonitoringController::class)->group(function () {
            Route::get('/monitoring', 'getSummary');
            Route::get('/latest', 'getLatest');
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



/**
 * ROUTE FOR GUEST (No logged in required)
 */
Route::prefix('download')
    ->controller(DocumentDownloadController::class)->group(function () {
        Route::get('/{id}', 'download');
        Route::get('/congress-draft', 'congressDraft');
        Route::get('/manual-book', 'manualBook');
    });

Route::prefix('assets')
    ->name('assets')
    ->controller(AssetController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{id}', 'show')->name('show');
        Route::get('/download/{id}', 'download')->name('download');
    });


Route::prefix('notifications')
    ->name('notifications.')
    ->controller(OrganizierNotificationController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/latest', 'latest')->name('latest');
    });
