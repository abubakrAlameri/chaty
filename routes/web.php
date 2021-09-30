<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\chat\MessageController;
use App\Http\Controllers\chat\ConversationController;



require __DIR__.'/auth.php';

Route::middleware(['auth','verified'])->group(function () {

        Route::get('/', [HomeController::class , 'create'])
        ->name('home');
        
        Route::post('/', [HomeController::class , 'create']);

        Route::post("/chats/add",[ConversationController::class , 'store'])
                ->name('chats.add');

        Route::post("/send" , [MessageController::class , 'send'])
                ->name('send.message');
});


