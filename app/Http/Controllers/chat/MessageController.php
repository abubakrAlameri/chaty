<?php

namespace App\Http\Controllers\chat;

use App\Models\User;
use App\Models\Message;
use App\Models\Participant;
use App\Models\TextMessage;
use App\Events\MessageEvent;
use Illuminate\Http\Request;
use App\Notifications\NewMessage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class MessageController extends Controller
{
    public function send(Request $request)
    {
    
        $user = User::join('participants' , 'participants.user_id' , '=' , 'users.id')
            ->where('participants.conv_id' , $request->currentConversation)
            ->where('participants.user_id' , '<>' , Auth::user()->id)
            ->first();
    
        $is_read = true;
        $inSameChat = Cache::get('user-chat-' . Auth::user()->id) == Cache::get('user-chat-' .  $user->id);
        $is_online = Cache::get('is_active-' . $user->id);
        // dd($user);   
        if(!$is_online)
        {
            Global $is_read;
            $is_read = false;

        }
        else if($is_online && !$inSameChat){
            // dd('here');
            Global $is_read;
            $is_read = false;
            $user->notify(new NewMessage(Auth::user(),$request->message, $request->currentConversation));
        }
       
       
       
        //fire event
        event(new MessageEvent(Auth::user(), $request->currentConversation , $request->message , $is_read));

        $participants = Auth::user()
                            ->participant()
                            ->where('conv_id', $request->currentConversation)
                            ->first();
                            
     
        $message = $participants->messages()
                            ->create(['type' => 'txt' , 'is_read' => $is_read]);
       TextMessage::create(['msg_id'=>$message->id,'text' => $request->message]);
    
      
        
        return ['success' => true];
    }
}
