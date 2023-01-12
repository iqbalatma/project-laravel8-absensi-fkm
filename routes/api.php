<?php

use App\Http\Controllers\API\v1\AssetController;
use App\Http\Controllers\API\v1\Auth\AuthController;
use App\Http\Controllers\API\v1\Auth\RegistrationController;
use App\Http\Controllers\API\v1\Auth\ResetPasswordController;
use App\Http\Controllers\API\v1\Auth\VerifyEmailController;
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
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
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
        // AUTH
        Route::group(
            ["controller" => AuthController::class],
            function () {
                Route::post("/login", "authenticate")->name("login");
                Route::post("/refresh", "refresh")->name("refresh");
                Route::post("/refresh", "refresh")->name("refresh");
                Route::post("/logout", "logout")->name("logout");
            }
        );

        // RESET PASSWORD
        Route::group(
            [
                "controller" => ResetPasswordController::class,
                "middleware" => "guest",
                "as" => "password.",
            ],
            function () {
                Route::post('/forgot-password', "requestResetLink")->name('email');
                Route::post('/reset-password', "resetPassword")->name('update');
            }
        );



        Route::post("registration/credential/{credential}", RegistrationController::class)->name("registration.with.credential");

        Route::middleware("auth:api")->group(
            function () {
                // ADMIN AND SUPERADMIN GROUPING
                Route::group(
                    [
                        "middleware" =>  "role:admin,superadmin"
                    ],
                    function () {
                        // ORGANIZATION
                        Route::group(
                            [
                                "controller" => OrganizationController::class,
                                "prefix" => "/organizations",
                                "as" => "organization.",
                            ],
                            function () {
                                Route::get("/", "index")->name("index")->withoutMiddleware("role:admin,superadmin");
                                Route::get("/{id}", "show")->name("show")->withoutMiddleware("role:admin,superadmin");;
                                Route::post("/", "store")->name("store");
                                Route::put("/{id}", "update")->name("update");
                                Route::delete("/{id}", "destroy")->name("destroy");
                            }
                        );


                        // CONGRESS DAY
                        Route::group(
                            [
                                "controller" => CongressDayController::class,
                                "prefix" => "/congress-days",
                                "as" => "congress.days."
                            ],
                            function () {
                                Route::get("/", "index")->name("index")->withoutMiddleware("role:admin,superadmin");
                                Route::get("/{id}", "show")->name("show")->withoutMiddleware("role:admin,superadmin");
                                Route::post("/", "store")->name("store");
                                Route::put("/{id}", "update")->name("update");
                                Route::delete("/{id}", "destroy")->name("destroy");
                            }
                        );


                        // REGISTRATION CREDENTIAL
                        Route::group(
                            [
                                "controller" => RegistrationCredentialController::class,
                                "prefix" => "/registration-credentials",
                                "as" => "registration.credentials."
                            ],
                            function () {
                                Route::get("/", "index")->name("index");
                                Route::get("/{id}", "show")->name("show");
                                Route::get("/token/{token}", "showByToken")->name("showByToken");
                                Route::post("/", "store")->name("store");
                                Route::put("/{id}", "update")->name("update");
                                Route::delete("/{id}", "destroy")->name("destroy");
                            }
                        );

                        // CHECKIN
                        Route::group(
                            [
                                "controller" => CheckinController::class,
                                "prefix" => "/checkin",
                                "as" => "checkin."
                            ],
                            function () {
                                Route::post("/manual", "checkinManual")->name("manual");
                                Route::post("/{personalToken}", "checkin")->name("personal.token");
                            }
                        );

                        Route::post("/checkout-all-users", CheckoutAllUserController::class)->name("checkout.all.users");

                        // CHECKIN STATUS
                        Route::group(
                            [
                                "controller" => CheckinStatusController::class,
                                "prefix" => "/checkin-statuses",
                                "as" => "checkin.statuses."
                            ],
                            function () {
                                Route::get("/", "index")->name("index");
                                Route::get("/latest", "latest")->name("latest");
                            }
                        );

                        Route::get("/monitoring", MonitoringController::class)->name("monitoring");

                        // USER MANAGEMENT
                        Route::group(
                            [
                                "controller" => UserManagementController::class,
                                "prefix" => "/users",
                                "as" => "users."
                            ],
                            function () {
                                Route::get("/", "index")->name("index");
                                Route::get("/{id}", "show")->name("show");
                                Route::post("/", "store")->name("store");
                                Route::post("/change-status/{id}", "changeActiveStatus")->name("change.active.status");
                                Route::put("/{id}", "update")->name("update");
                            }
                        );
                    }
                );


                // VERIFY EMAIL
                Route::group(
                    [
                        "controller" => VerifyEmailController::class,
                        "prefix" => "email",
                        "as" => "verification."
                    ],
                    function () {
                        Route::post('/verification-notification', "resend")->middleware(['throttle:6,1'])->name('resend');
                        Route::get('/verify/{id}/{hash}', "verify")->middleware(['signed'])->name('verify');
                    }
                );


                // ASSET
                Route::group(
                    [
                        "controller" => AssetController::class,
                        "prefix" => "/assets",
                        "as" => "assets."
                    ],
                    function () {
                        Route::get("/", "index")->name("index");
                        Route::get("/{id}", "show")->name("show");
                        Route::get("/download/{id}", "download")->name("download");
                    }
                );

                // ORGANIZER NOTIFICATION
                Route::group(
                    [
                        "controller" => OrganizerNotificationController::class,
                        "prefix" => "/organizer-notifications",
                        "as" => "organizer.notifications."
                    ],
                    function () {
                        Route::get("/", "index")->name("index");
                        Route::get("/latest", "latest")->name("latest");
                        Route::post("/", "store")->name("store")->middleware("role:admin,superadmin");
                    }
                );

                // MY PROFILE
                Route::group(
                    [
                        "controller" => MyProfileController::class,
                        "prefix" => "/my-profile",
                        "as" => "my.profile"
                    ],
                    function () {
                        Route::get("/", "show")->name("show");
                        Route::put("/", "update")->name("update");
                    }
                );
            }
        );
    }
);
