<?php

declare(strict_types=1);

/**
 * Custom Controllers.
 */
use App\Http\Controllers\Announcement\AnnouncementController;
use App\Http\Controllers\Attendance\AttendancesController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\OAuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Course\CourseCategoryController;
use App\Http\Controllers\Course\CourseCommentController;
use App\Http\Controllers\Course\CourseController;
use App\Http\Controllers\Course\UserCourseController;
use App\Http\Controllers\Handbook\HandbookController;
use App\Http\Controllers\Handbook\HandbookPageController;
use App\Http\Controllers\LeaveApplication\LeaveApplicationsController;
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
            Route::get('/download/{id}', [HandbookController::class, 'download'])->name('download');
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

    /**
     * Attendance Modules.
     */
    Route::name('attendances.')
        ->prefix('attendance')
        ->group(function () {
            Route::get('/today', [AttendancesController::class, 'today'])->name('today');
            Route::get('/', [AttendancesController::class, 'index'])->name('list');
            Route::post('/timein', [AttendancesController::class, 'time_in'])->name('time_in');
            Route::put('/timeout', [AttendancesController::class, 'time_out'])->name('time_out');
            Route::get('/employee', [AttendancesController::class, 'employee'])->name('employee');
            Route::get('/get/{id}', [AttendancesController::class, 'get'])->name('show');
            Route::put('/update/{id}', [AttendancesController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [AttendancesController::class, 'destroy'])->name('delete');
        });

    /**
     * Course Category Modules.
     */
    Route::name('course_category.')
        ->prefix('course_category')
        ->group(function () {
            Route::get('fetch', [CourseCategoryController::class, 'index'])->name('list');
            Route::get('/{id}', [CourseCategoryController::class, 'get'])->name('single');
            Route::post('/', [CourseCategoryController::class, 'store'])->name('store');
            Route::put('/update/{id}', [CourseCategoryController::class, 'update'])->name('update');
            Route::delete('/{id}', [CourseCategoryController::class, 'destroy'])->name('delete');
        });

    /**
     * Course Modules.
     */
    Route::name('course.')
        ->prefix('course')
        ->group(function () {
            Route::get('fetch', [CourseController::class, 'index'])->name('list');
            Route::get('/{id}', [CourseController::class, 'get'])->name('single');
            Route::post('/', [CourseController::class, 'store'])->name('store');
            Route::put('/update/{id}', [CourseController::class, 'update'])->name('update');
            Route::delete('/{id}', [CourseController::class, 'destroy'])->name('delete');
            Route::post('/upload', [CourseController::class, 'upload'])->name('upload');
        });

    /**
     * Leaves.
     */
    Route::name('leaves.')
        ->prefix('leave')
        ->group(function () {
            Route::get('/', [LeaveApplicationsController::class, 'index'])->name('list');
            Route::get('/{id}', [LeaveApplicationsController::class, 'get'])->name('single');
            Route::post('/', [LeaveApplicationsController::class, 'store'])->name('store');
            Route::put('/{id}', [LeaveApplicationsController::class, 'update'])->name('update');
            Route::delete('/{id}', [LeaveApplicationsController::class, 'destroy'])->name('delete');
        });

    /**
     * User Courses.
     */
    Route::name('user_course.')
        ->prefix('user_course')
        ->group(function () {
            Route::get('/', [UserCourseController::class, 'index'])->name('list');
            Route::get('/{id}', [UserCourseController::class, 'get'])->name('single');
            Route::post('/subscribe', [UserCourseController::class, 'subscribe'])->name('subscribe');
            Route::delete('/unsubscribe/{id}', [UserCourseController::class, 'unsubscribe'])->name('unsubscribe');
            Route::put('/process', [UserCourseController::class, 'process'])->name('process');
        });

    /**
     * User Courses.
     */
    Route::name('course_comment.')
        ->prefix('course_comment')
        ->group(function () {
            Route::post('/post', [CourseCommentController::class, 'store'])->name('store');
            Route::delete('/{id}', [CourseCommentController::class, 'destroy'])->name('delete');
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
