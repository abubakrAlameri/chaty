<?php

namespace App\Http\Controllers;
use DB;
use App\Models\User;
use App\Models\Message;
use App\Models\FileMessage;
use App\Models\Participant;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
use App\Events\ReadMessageEvent;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function create(Request $request){
        // dd('l');
        
        Cache::put('user-chat-' . Auth::user()->id, $request->conv_id);
        $messages = null;
        if($request->conv_id){
            $messages = $this->getMessages($request->conv_id);
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

        return view('chat.home' , [
            'conversations' => $conversations,
            'messages' => $messages,
            'name' => $request->name,
        ]);
    }
    public function getMessages($conv_id)
    {
    
        $textMessages = User::select(
            'participants.part_id',
            'participants.conv_id',
            'participants.user_id',
            'users.email',
            'users.name',
            'messages.msg_id',
            'messages.is_read',
            'messages.type',
            'text_messages.text',
            'text_messages.created_at',
        )
        ->join('participants', 'participants.user_id', '=' , 'users.id')
        ->join('messages','messages.part_id', '=', 'participants.part_id')
        ->join('text_messages','text_messages.msg_id' , '=' , 'messages.msg_id')
        ->where('participants.conv_id', $conv_id)
        ->orderBy('created_at')
        ->get();
       
        
        $fileMessages = User::select(
            'participants.part_id',
            'participants.conv_id',
            'participants.user_id',
            'users.email',
            'users.name',
            'messages.msg_id',
            'messages.is_read',
            'messages.type',
            'file_messages.path',
            'file_messages.size',
            'file_messages.created_at',
        )
        ->join('participants', 'participants.user_id', '=' , 'users.id')
        ->join('messages','messages.part_id', '=', 'participants.part_id')
        ->join('file_messages','file_messages.msg_id' , '=' , 'messages.msg_id')
        ->where('participants.conv_id', $conv_id)
        ->orderBy('created_at')
        ->get();


        $messages = $textMessages->concat($fileMessages);
        $messages = $messages->sortBy('created_at');
        if($messages->count() > 0 ){
            $msg = $messages->where('user_id' , '<>' , Auth::user()->id )->first();
            $part_id = isset($msg->part_id) ? $msg->part_id : null;
            // dd($messages);
            // dd($part_id);
            Message::where('part_id', $part_id)
                ->where('is_read',0)
                ->update(['is_read'=> 1]);
        }
        event( New ReadMessageEvent(Auth::user(),$conv_id));
        session(['currentConversations' => $conv_id]);
        return $messages;
    }
}