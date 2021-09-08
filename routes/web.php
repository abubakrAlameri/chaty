<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\chat\MessageController;
use App\Http\Controllers\chat\ConversationController;



require __DIR__.'/auth.php';


Route::get('/chat', [HomeController::class , 'create'])
        ->middleware(['auth','verified'])
        ->name('home');
Route::post('/chat', [HomeController::class , 'create']);

Route::post("/chats/add",[ConversationController::class , 'store'])
        ->middleware('auth')
        ->name('chats.add');

Route::post("/send" , [MessageController::class , 'send'])
        ->middleware('auth')
        ->name('send.message');
