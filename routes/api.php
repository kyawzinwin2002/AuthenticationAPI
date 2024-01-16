<?php

use App\Http\Controllers\Api\Auth\ChangePasswordController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\VerifyEmailController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix("v1")->group(function () {
    Route::post("register", [RegisterController::class, "register"]);
    Route::post("login", [LoginController::class, "login"]);

    Route::middleware("auth:sanctum")->group(function () {
        Route::post("change", [ChangePasswordController::class, "change"]);

        Route::controller(VerifyEmailController::class)->group(function () {
            Route::get("email/verify/{id}/{hash}", "verify")
                ->middleware("signed")
                ->name("verification.verify");
            Route::post("email/verification-notification","send")
                ->middleware("throttle:6,1")
                ->name("verification.send");
        });
    });
});
