<?php

namespace App\Http\Controllers\chat;

use App\Models\User;
use App\Models\Participant;
use App\Models\Conversation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request,[
            'email' => 'required|email',
        ]);

        $newFriend = User::Where('email', $request->email)
                            ->where('email', '<>' , Auth::user()->email)
                            ->first();
      
        if($newFriend){
            // check if we already have conversation
            $participants = Participant::select('conv_id')
                                        ->where('user_id', $newFriend->id)
                                        ->orWhere('user_id', Auth::user()->id)
                                        ->get()
                                        ->pluck('conv_id');


            $unique = $participants->unique();

            if($unique->count() == $participants->count()){

                $newConversation = Conversation::create([]);
                $newFriend->participant()->create([
                      'conv_id' => $newConversation->id,
                ]); 

                Auth::user()->participant()->create([
                    'conv_id' => $newConversation->id,
                ]);



                return back()->with([
                    'message' => 'added successfully',
                    'color' => 'text-green-600',
                ]);
  
            }
            else{
                return back()->with([
                    'message' => 'you already have chat with this email',
                    'color' => 'text-red-600',
                
                ]);
            }
           
        }
        return back()->with([
            'message' => 'email is not found',
            'color' => 'text-red-600',
        
        ]);
    }

    public function destroy(Request $request)
    {
        //remover conversation
    }
}