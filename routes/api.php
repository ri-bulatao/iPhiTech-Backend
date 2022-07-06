<?php

/**
 * Custom Controllers
 */
use App\Http\Controllers\Announcement\AnnouncementController;

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
    Route::post('logout', [LoginController::class, 'logout']);

    Route::get('user', [UserController::class, 'current']);

    Route::patch('settings/profile', [ProfileController::class, 'update']);
    Route::patch('settings/password', [PasswordController::class, 'update']);

    
    /**
     * Announcement Modules
     */ 
    Route::prefix('announcements')->group(function() {
        Route::get('fetch', [AnnouncementController::class, 'index'])->name('announcement.list');
        Route::get('/{id}', [AnnouncementController::class, 'get'])->name('announcement.single');
        Route::post('/', [AnnouncementController::class, 'store'])->name('announcement.store');
        Route::put('/update/{id}', [AnnouncementController::class, 'update'])->name('announcement.update');
        Route::delete('/{id}', [AnnouncementController::class, 'delete'])->name('announcement.delete');
    });
});

Route::group(['middleware' => 'guest:api'], function () {
    
    // Admin Login
    Route::post('/admin/login', [AdminLoginController::class, 'login']);

    // User Authentication
    Route::post('login', [LoginController::class, 'login']);
    Route::post('register', [RegisterController::class, 'register']);

    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail']);
    Route::post('password/reset', [ResetPasswordController::class, 'reset']);

    Route::post('email/verify/{user}', [VerificationController::class, 'verify'])->name('verification.verify');
    Route::post('email/resend', [VerificationController::class, 'resend']);

    Route::post('oauth/{driver}', [OAuthController::class, 'redirect']);
    Route::get('oauth/{driver}/callback', [OAuthController::class, 'handleCallback'])->name('oauth.callback');
});
