<?php

namespace App\Http\Controllers\auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function create(Request $request)
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $credentials = $this->validate($request,[
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $remember_me =$request->remember_me == "on"? true : false;
       
        if(Auth::attempt($credentials, $remember_me)){
            return redirect('/chat');
        }

        return back()->with([
            'loginFialed' => 'some information are wrong'
        ]);
    }

    public function destroy(Request $request)
    {   
         Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
        
    }
}
