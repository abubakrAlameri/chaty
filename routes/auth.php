<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\auth\RegisterController;
use App\Http\Controllers\auth\VerifyEmailController;

Route::get('/login', [LoginController::class , 'create'])->name('login');
Route::post('/login', [LoginController::class , 'store'])->name('signin');
Route::post('/logout', [LoginController::class , 'destroy'])->name('logout');


Route::get('/register', [RegisterController::class , 'create'])->name('signup');
Route::post('/register', [RegisterController::class , 'store'])->name('register');


Route::get('/email/verify', [VerifyEmailController::class , 'create'])
        ->middleware('auth')
        ->name('verification.notice');
        
Route::post('/email/resend', [VerifyEmailController::class , 'resend'])
        ->middleware(['auth', 'throttle:6,1'])
        ->name('verification.resend');

Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class , 'store'])
        ->middleware(['auth', 'signed'])
        ->name('verification.verify');
