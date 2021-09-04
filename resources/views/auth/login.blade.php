@extends('layouts.app')
@section('title')
    Login
@endsection
@section('content')
   
   <div class="bg-grey-lighter min-h-screen flex flex-col">
            <div class="container max-w-sm mx-auto flex-1 flex flex-col items-center justify-center px-2">
                <div class="bg-white px-6 py-8 rounded shadow-md text-black w-full">
                    <h1 class="mb-8 text-3xl text-center text-indigo-700">Log In</h1>
                    <form action="{{route('signin')}}" method="post">
                        @csrf
                      
                        <input 
                            type="email"

                            class="block border border-grey-light w-full p-3 rounded mb-4
                                    @error('email')
                                        border-red-600
                                        bg-red-200
                                    @enderror
                                    "
                            name="email"
                            value="{{old('email')}}"
                            placeholder="Email" />
                        @error('email')
                            <div class="text-red-500 mt-2 text-sm ">
                                {{$message}}
                            </div>
                        @enderror


                        <input 
                            type="password"
                            class="block border border-grey-light w-full p-3 rounded mb-4
                                    @error('password')
                                        border-red-600
                                        bg-red-200
                                    @enderror
                                    "
                            name="password"
                            placeholder="Password" />

                        @error('password')
                            <div class="text-red-500 mt-2 text-sm ">
                                {{$message}}
                            </div>
                        @enderror
                        <input 
                            type="checkbox" 
                            name="remember_me" 
                            class='border border-grey-light bg-indigo-700 p-3 rounded mb-4' 
                             id="remember_me">
                            <label for="remember_me" class='text-gray-800'>Remember me</label>
                        <button
                            type="submit"
                            class="w-full text-center py-3 rounded bg-indigo-700 text-white hover:bg-indigo-800 focus:outline-none my-1"
                        >login</button>
                    </form>
                    @if (session()->has('loginFialed'))
                        <div class="bg-red-300 py-3 px-2 text-white  rounded ">{{session()->get('loginFialed')}}</div>
                    @endif  
                </div>

                <div class="text-grey-300 mt-6">
                    Don't have an account? 
                    <a class="no-underline border-b text-indigo-800 border-blue text-blue" href="{{route('signup')}}">
                        Sign Up
                    </a>.
                </div>
            </div>
        </div>
@endsection