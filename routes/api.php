<?php

declare(strict_types=1);

/**
 * Custom Controllers.
 */
use App\Http\Controllers\Announcement\AnnouncementController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\OAuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Handbook\HandbookController;
use App\Http\Controllers\Handbook\HandbookPageController;
use App\Http\Controllers\Notification\NotificationsController;
use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\User\PositionController;
use App\Http\Controllers\User\UserController as AdminUserController;
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

Route::get('/menu', [AnnouncementController::class, 'test'])->name('test');

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

    /**
     * Announcement Modules.
     */
    Route::name('announcements.')
        ->prefix('announcements')
        ->group(function () {
            Route::get('/', [AnnouncementController::class, 'index'])->name('list');
            Route::get('/{id}', [AnnouncementController::class, 'get'])->name('single');
            Route::post('/', [AnnouncementController::class, 'store'])->name('store');
            Route::post('/upload', [AnnouncementController::class, 'upload'])->name('upload');
            Route::put('/post', [AnnouncementController::class, 'post'])->name('post');
            Route::put('/update/{id}', [AnnouncementController::class, 'update'])->name('update');
            Route::delete('/{id}', [AnnouncementController::class, 'delete'])->name('delete');
        });

    /**
     * Notification Module.
     */
    Route::name('notifications.')
        ->prefix('notifications')
        ->group(function () {
            Route::get('/', [NotificationsController::class, 'index'])->name('list');
            Route::get('unread', [NotificationsController::class, 'unread'])->name('unread');
            Route::put('/{id}', [NotificationsController::class, 'update'])->name('update');
            Route::delete('/{id}', [NotificationsController::class, 'delete'])->name('delete');
        });

    /**
     * Positions Modules.
     */
    Route::prefix('positions')->group(function () {
        Route::get('fetch', [PositionController::class, 'index'])->name('position.list');
        Route::get('/{id}', [PositionController::class, 'get'])->name('position.single');
        Route::post('/', [PositionController::class, 'store'])->name('position.store');
        Route::put('/update/{id}', [PositionController::class, 'update'])->name('position.update');
        Route::delete('/{id}', [PositionController::class, 'destroy'])->name('position.delete');
    });

    /**
     * Admin User Modules.
     */
    Route::prefix('admin_user')->group(function () {
        Route::get('fetch', [AdminUserController::class, 'index'])->name('admin_user.list');
        Route::get('/{id}', [AdminUserController::class, 'get'])->name('admin_user.single');
        Route::post('/', [AdminUserController::class, 'store'])->name('admin_user.store');
        Route::put('/update/{id}', [AdminUserController::class, 'update'])->name('admin_user.update');
        Route::delete('/{id}', [AdminUserController::class, 'destroy'])->name('admin_user.delete');
    });

    /**
     * Handbook Modules.
     */
    Route::name('handbook.')
        ->prefix('handbook')
        ->group(function () {
            Route::get('/', [HandbookController::class, 'index'])->name('all');
            Route::get('/{id}', [HandbookController::class, 'get'])->name('show');
            Route::post('/', [HandbookController::class, 'store'])->name('store');
            Route::put('/update/{id}', [HandbookController::class, 'update'])->name('update');
            Route::delete('/{id}', [HandbookController::class, 'destroy'])->name('delete');
        });

    Route::name('handbook_page.')
        ->prefix('handbook_page')
        ->group(function () {
            Route::get('/{id}', [HandbookPageController::class, 'get'])->name('all');
            Route::get('/single/{id}', [HandbookPageController::class, 'show'])->name('show');
            Route::post('/', [HandbookPageController::class, 'store'])->name('store');
            Route::put('/update/{id}', [HandbookPageController::class, 'update'])->name('update');
            Route::delete('/{id}', [HandbookPageController::class, 'destroy'])->name('delete');
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
