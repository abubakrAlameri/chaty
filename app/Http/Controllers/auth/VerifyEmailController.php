<?php

namespace App\Http\Controllers\auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class VerifyEmailController extends Controller
{
    
    public function create(Request $request) {
        
        return view('auth.verify');
    }
    public function store(EmailVerificationRequest $request) {
        $request->fulfill();
       
        return redirect()->route('home');
    }
    public function resend(Request $request) 
    {
        if(Auth::user()->hasVerifiedEmail()){
            return redirect()->route('home');
        }
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Verification link sent!');
    }
}
