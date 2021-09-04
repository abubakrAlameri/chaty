@extends('layouts.app')

@section('title')
    Verify Email
@endsection

@section('content')
    <div class="w-screen h-screen flex justify-center items-center">
        <div class="w-96 h-96 text-gray-700">
            <p class="font-bold">we send you an email to confirm your email address</p>
            <p class="font-semibold">CHECK your inbox 
                <form class='inline-block' action="{{route('verification.resend')}}" method="post">
                    @csrf
                    <button class="text-indigo-700 inline-block underline">resend</button>
                </form>
            </p>
             @if(session()->has('message'))
                <div class='text-green-400 font-semibold w-full mt-3 '>
                    {{session()->get('message')}}
                </div>
            @endif
            
        </div>

    </div>
@endsection 