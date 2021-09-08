<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });
//ArgumentCountError: Too few arguments to function App\Providers\BroadcastServiceProvider::{closure}(), 1 passed in C:\xampp\htdocs\chaty\vendor\laravel\framework\src\Illuminate\Broadcasting\Broadcasters\Broadcaster.php on line 84 and exactly 2 expected in file C:\xampp\htdocs\chaty\routes\channels.php on line 21



Broadcast::channel("chat.{currentConversation}", function ($user, $currentConversation){
    //  Auth::check();
    return true;
});