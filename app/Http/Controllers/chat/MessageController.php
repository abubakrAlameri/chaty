<?php

namespace App\Http\Controllers\chat;

use App\Models\Message;
use App\Events\MessageEvent;
use App\Models\Participant;
use App\Models\TextMessage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function send(Request $request)
    {
        
        
        //fire event
        event(new MessageEvent(Auth::user(), $request->currentConversation,$request->message));
        //add to database
        $participants = Auth::user()
                            ->participant()
                            ->where('conv_id', $request->currentConversation)
                            ->first();
     
        $message = $participants->messages()
                            ->create(['type' => 'txt' , 'is_read' => true]);

       $message->textMessages()->create(['text' => $request->message]);
    
      
        
        return ['success' => true];
    }
}
