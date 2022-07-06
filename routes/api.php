<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\OAuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\ProfileController;
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

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('user', [UserController::class, 'current'])->name('user.profile');

    // Settings
    Route::name('settings.')
    ->prefix('settings')
    ->group(function () {
        Route::patch('/profile', [ProfileController::class, 'update'])->name('update.profile');
        Route::patch('/password', [PasswordController::class, 'update'])->name('update.password');
    });
});

Route::group(['middleware' => 'guest:api'], function () {

    // Admin
    Route::name('admin.')
    ->prefix('admin')
    ->group(function () {
        // Admin Login
        Route::post('/login', [AdminLoginController::class, 'login'])->name('login');
    });

    // User Authentication
    Route::post('login', [LoginController::class, 'login'])->name('login');
    Route::post('register', [RegisterController::class, 'register'])->name('register');

    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email-reset');
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.reset');

    Route::post('email/verify/{user}', [VerificationController::class, 'verify'])->name('verification.verify');
    Route::post('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');

    Route::post('oauth/{driver}', [OAuthController::class, 'redirect'])->name('oauth.redirect');
    Route::get('oauth/{driver}/callback', [OAuthController::class, 'handleCallback'])->name('oauth.callback');
});
