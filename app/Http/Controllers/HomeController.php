<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Participant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function create(Request $request){
       
        $participants = Auth::user()->participant()->select('conv_id')
                                ->where('user_id' , Auth::user()->id)
                                ->pluck('conv_id');
        $conversations = Participant::join('users', 'participants.user_id', '=' , 'users.id')
                                    ->whereIn('conv_id', $participants)
                                    ->where('user_id' , '<>' , Auth::user()->id)
                                    ->get();

        // for each conversation

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
            // dd($messages);
            session(['currentConversations' => $request->conv_id]);
        } 

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