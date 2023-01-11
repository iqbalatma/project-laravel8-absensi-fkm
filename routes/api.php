<?php

use App\Http\Controllers\API\v1\AssetController;
use App\Http\Controllers\API\v1\Auth\AuthController;
use App\Http\Controllers\API\v1\Auth\RegistrationController;
use App\Http\Controllers\API\v1\CheckinController;
use App\Http\Controllers\API\v1\CheckinStatusController;
use App\Http\Controllers\API\v1\CheckoutAllUserController;
use App\Http\Controllers\API\v1\CongressDayController;
use App\Http\Controllers\API\v1\MonitoringController;
use App\Http\Controllers\API\v1\MyProfileController;
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

Route::group(
    ["prefix" => "/v1"],
    function () {

        Route::group(
            ["controller" => AuthController::class],
            function () {
                Route::post("/login", "authenticate")->name("login");
                Route::post("/refresh", "refresh")->name("refresh");
                Route::post("/refresh", "refresh")->name("refresh");
                Route::post("/logout", "logout")->name("logout");
            }
        );

        Route::post(
            "registration/credential/{credential}",
            [RegistrationController::class, "registrationWithCredential"]
        )->name("registration.with.credential");



        Route::middleware("auth:api")->group(
            function () {
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

                Route::controller(AssetController::class)
                    ->prefix("/assets")
                    ->name("assets.")
                    ->group(
                        function () {
                            Route::get("/", "index")->name("index");
                            Route::get("/{id}", "show")->name("show");
                            Route::get("/download/{id}", "download")->name("download");
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
                            Route::post("/change-status/{id}", "changeActiveStatus")->name("change.active.status");
                            Route::put("/{id}", "update")->name("update");
                        }
                    );

                Route::controller(MyProfileController::class)
                    ->prefix("/my-profile")
                    ->name("my.profile.")
                    ->group(
                        function () {
                            Route::get("/", "show")->name("show");
                        }
                    );
            }
        );
    }
);


    // Route::group([])
