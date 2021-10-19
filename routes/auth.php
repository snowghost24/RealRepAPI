<?php

use App\Http\Controllers\NewPasswordController;
use App\Http\Controllers\PasswordResetLinkController;
use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\Auth\AuthenticatedSessionController;
//use App\Http\Controllers\Auth\ConfirmablePasswordController;
//use App\Http\Controllers\Auth\EmailVerificationNotificationController;
//use App\Http\Controllers\Auth\EmailVerificationPromptController;
//use App\Http\Controllers\Auth\NewPasswordController;
//use App\Http\Controllers\Auth\PasswordResetLinkController;
//use App\Http\Controllers\Auth\RegisteredUserController;
//use App\Http\Controllers\Auth\VerifyEmailController;
////use Illuminate\Support\Facades\Route;

///
// mobile auth routes
//Route::get('/register', [RegisteredUserController::class, 'create'])
//                ->middleware('guest')
//                ->name('register');
//
//Route::post('/register', [RegisteredUserController::class, 'store'])
//                ->middleware('guest');
//
//Route::get('/login', [AuthenticatedSessionController::class, 'create'])
//                ->middleware('guest')
//                ->name('login');
//
//Route::post('/login', [AuthenticatedSessionController::class, 'store'])
//                ->middleware('guest');

//Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
//                ->middleware('auth')
//                 ->name('logout');
//
Route::get('/login', function (){
    return view();
});
//    ->middleware('guest')
//    ->name('password.request');

Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
                ->middleware('guest')
                ->name('password.request');

Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
                ->middleware('guest')
                ->name('password.reset');

Route::get('/reset-password-complete', function (){
    return view('auth.reset-password-complete');
})->name('password.reset-complete');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
                ->middleware('guest')
                ->name('password.update');

Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store'])
                ->middleware('auth');



//Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
//                ->middleware('guest')
//                ->name('password.email');
//




//
//Route::post('/reset-password', [NewPasswordController::class, 'store'])
//                ->middleware('guest')
//                ->name('password.update');
//


//Route::get('/verify-email', [EmailVerificationPromptController::class, '__invoke'])
//                ->middleware('auth')
//                ->name('verification.notice');
//
//Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
//                ->middleware(['auth', 'signed', 'throttle:6,1'])
//                ->name('verification.verify');
//
//Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
//                ->middleware(['auth', 'throttle:6,1'])
//                ->name('verification.send');
//
//Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])
//                ->middleware('auth')
//                ->name('password.confirm');
//
//Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store'])
//                ->middleware('auth');
//

