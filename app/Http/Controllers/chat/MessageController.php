<?php

namespace App\Http\Controllers\chat;

use App\Models\User;
use App\Models\Message;
use App\Models\FileMessage;
use App\Models\Participant;
use App\Models\TextMessage;
use App\Events\MessageEvent;
use Illuminate\Http\Request;
use App\Notifications\NewMessage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class MessageController extends Controller
{
    public function send(Request $request)
    {
        $conv = $request->currentConversation;
        $msgType = $request->type;
        $user = User::join('participants' , 'participants.user_id' , '=' , 'users.id')
        ->where('participants.conv_id' , $conv)
        ->where('participants.user_id' , '<>' , Auth::user()->id)
        ->first();
        
        $is_read = true;
        $is_online = Cache::get('is_active-' . $user->id);
        
        $message = $this->getMessage($request);
      
        if(!$is_online)
        {
            $is_read = false;

        }
        else if($is_online && !$this->inSameChat($user->id)){
            $is_read = false;
            // dd($msgType);    
            $user->notify(new NewMessage(Auth::user(),$message, $conv ,$msgType));
        }
       
       

        if($msgType != 'text' ){
            event(new MessageEvent(Auth::user(), $conv , asset('storage/' . $message) , $is_read , $msgType ,$request->size));

        }else{
            event(new MessageEvent(Auth::user(), $conv , $message , $is_read , $msgType , $request->size));

        }
        // dd($msgType);
       
        $participants = Auth::user()
                            ->participant()
                            ->where('conv_id', $conv)
                            ->first();
        $newMessage = $participants->messages()
                            ->create(['type' => $msgType , 'is_read' => $is_read]);
        if($msgType == "text"){
            TextMessage::create(['msg_id'=>$newMessage->id,'text' => $message]);
        }else{

            FileMessage::create(['msg_id'=>$newMessage->id,'path' => $message , 'size' => $request->size]);
        }              
     
    
      
        
        return ['success' => true];
    }
    public function inSameChat($user_id)
    {
        $bool = Cache::get('user-chat-' . Auth::user()->id) == Cache::get('user-chat-' .  $user_id);
        return $bool; 

    }
 
    public function getMessage($request)
    {
        $msgType = $request->type;
        $message = '';
        if ($msgType != 'text') {
            $message = $request
                ->file('message')
                ->storePublicly($msgType.'/conversation' . $request->currentConversation,'public');
            

        }else{
            $message = $request->message; 
        }
        return $message; 
   
    }
}
