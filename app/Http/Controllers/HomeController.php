<?php

namespace App\Http\Controllers;
use DB;
use App\Models\User;
use App\Models\Message;
use App\Models\Participant;
use Illuminate\Http\Request;
use App\Events\ReadMessageEvent;
// use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function create(Request $request){
        
        
        Cache::put('user-chat-' . Auth::user()->id, $request->conv_id);
        $messages = null;
        if($request->conv_id){
            $messages = User::select(
                'participants.part_id',
                'participants.conv_id',
                'participants.user_id',
                'users.email',
                'users.name',
                'messages.msg_id',
             
                'messages.is_read',
                'text_messages.text',
                'text_messages.created_at',
            )
            ->join('participants', 'participants.user_id', '=' , 'users.id')
            ->join('messages','messages.part_id', '=', 'participants.part_id')
            ->join('text_messages','text_messages.msg_id' , '=' , 'messages.msg_id')
            ->where('participants.conv_id', $request->conv_id)
            ->orderBy('created_at')
            ->get();
            for($i = $messages->count() - 1; $i >= 0; $i--){
                if($messages[$i]->is_read == 1){
                    break;
                }

                if($messages[$i]->email != Auth::user()->email)
                {
                    $messages[$i]->is_read = 1;
                    Message::where('msg_id', $messages[$i]->msg_id)
                        ->update(['is_read'=> 1]);
                }
            }
          
        
           
            event( New ReadMessageEvent(Auth::user(),$request->conv_id));
            
     
            session(['currentConversations' => $request->conv_id]);
        } 

        $participants = Auth::user()->participant()
            ->select('conv_id')
            ->where('user_id' , Auth::user()->id)
            ->pluck('conv_id');
        DB::statement("SET SQL_MODE=''");
        $conversations = User::select(
            'conv_id',
            'user_id',
            'participants.part_id',
            'name',
            'email',
            'last_seen',
            DB::raw("
                COUNT(
                CASE
                WHEN is_read= 0
                THEN 1
                ELSE NULL
                END
                ) AS unread_count
            ")
        )
        ->join('participants', 'users.id', '=' , 'participants.user_id')
        ->leftJoin('messages', 'participants.part_id', '=', 'messages.part_id')
        ->where('user_id' , '<>' , Auth::user()->id)
        ->whereIn('conv_id', $participants)
        ->groupBy('conv_id')
        ->get();
        // dd($conversations);

        return view('chat.home' , [
            'conversations' => $conversations,
            'messages' => $messages,
            'name' => $request->name,
        ]);
    }
    public function dipaly(Request $request)
    {
        
    }
}