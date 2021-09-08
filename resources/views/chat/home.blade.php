@extends('layouts.app')

@section('title')
    Home
@endsection
{{-- {{dd( $messages)}} --}}
@section('content')
      <div  class="flex h-screen antialiased text-gray-800">
        <div id='contianer'  class="flex md:flex-row flex-col h-auto w-full overflow-x-hidden">
            <div class='md:hidden flex content-start items-center sticky top-0  bg-white w-full z-50 h-20 cursor-pointer mr-auto  mt-8' onclick='showSidbar()'>
                <svg class='mr-auto  my-4  ml-10 ' width="47" height="26" viewBox="0 0 47 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="47" height="4" rx="2" fill="#4338CA" />
                    <rect y="11" width="47" height="4" rx="2" fill="#4338CA" />
                    <rect y="22" width="47" height="4" rx="2" fill="#4338CA" />
                </svg>
            

            </div>
            <!--! start sid bar` -->
            <div id="sidbar" class="md:transform -translate-x-96 transition-all duration-75 hidden md:flex fixed flex-col h-full  md:sticky top-0 py-8 pl-4 pr-4 md:w-64 w-full z-50  bg-white flex-shrink-0">

              
                <!-- LOGO -->
                <div class="flex  flex-row items-center justify-between h-12 w-full">
                    <div class="flex items-center justify-around rounded-2xl text-indigo-700 bg-indigo-100 h-10 md:w-full sm:w-1/2 w-3/4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                            </path>
                        </svg>
                        <p class="text-gray-800 font-bold pr-4">
                            {{auth()->user()->name}}
                        </p>
                    </div>
                    <div class='cursor-pointer block md:hidden' onclick='hideSidbar()'> 
                        <svg  width="37" height="37" viewBox="0 0 37 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect y="33.234" width="47" height="4" rx="2" transform="rotate(-45 0 33.234)" fill="#4338CA" />
                            <rect x="2.82843" y="1.52588e-05" width="47" height="4" rx="2" transform="rotate(45 2.82843 1.52588e-05)"
                                fill="#4338CA" />
                        </svg>
                    </div>
                  
                </div>
                <!-- personal-info -->
                <div
                    class="flex  flex-col items-center bg-indigo-100 border border-gray-200 mt-4 w-full py-6 px-4 rounded-lg">

                    <form action="{{route('chats.add')}}" method="post" class="w-full h-full">
                        @csrf
                        <input 
                            type="text" 
                            name="email" 
                            class="h-10 w-8/12 rounded-lg 
                            @error('email')
                                border-red-600
                                bg-red-300
                            @enderror ">
                            @error('email')
                                <div class="text-red-600 text-sm">{{$message}}</div>
                            @enderror
                        <button type="submit" class="bg-indigo-700 text-white w-3/12 h-10 rounded-lg">add</button>
                        @if(session()->has('message'))
                            <div class="{{session()->get('color')}} text-sm">{{session()->get('message')}}</div>
                        @endif
                    </form>
                </div>

                <!-- convarsations -->
                <div class="flex   flex-col mt-8 max-h-80"  >
                    <div class="flex flex-row items-center justify-between text-xs">
                        <span class="font-bold">Active Conversations</span>
                        <span class="flex items-center justify-center bg-gray-300 h-4 w-4 rounded-full">{{$conversations->count()}}</span>
                    </div>
                    <div class="flex flex-col space-y-1 mt-4 -mx-2  overflow-y-auto">
                    
                    @foreach ($conversations as $con)
                        <form action="{{route('home')}}" method="post" class="conversation w-full">
                            @csrf
                            <input type="hidden" name="conv_id" value="{{$con->conv_id}}">
                            <input type="hidden" name="name" value="{{$con->name}}">
                            <button class="flex flex-row items-center w-full hover:bg-gray-100 rounded-xl p-2">
                                <div class="flex items-center justify-center h-8 w-8 bg-gray-200 rounded-full font-bold">
                                    {{Str::upper($con->name[0])}}
                                </div>
                                <div class="ml-2 text-sm font-semibold">{{$con->name}}</div>
                                @if (false)
                                     <div class="flex items-center 
                                            justify-center ml-auto
                                            text-xs text-white 
                                            bg-red-500 h-4 w-4 rounded leading-none"
                                            >
                                       {{-- {{}} --}}
                                    </div>
                                @endif
                               
                            </button>
                        </form>
                        

                    @endforeach

                        
                    
                    </div>
                   <form action="{{route('logout')}}" method="post" class="w-full mt-10">
                       @csrf
                        <button type="submit" class="bg-red-500 text-white w-full h-10 rounded-lg">logout</button>
                    </form>
                </div>
            </div>
            <!--! end sid bar` -->


            <!--! start chat body -->
            <div class="flex flex-col flex-auto min-h-0 p-4 ">
                <!--! sratr chat content -->
                <div class="flex flex-col  flex-shrink-0  rounded-2xl bg-gray-100 min-h-screen  p-4" >
                        <div class=" min-h-full overflow-x-hidden">
                            <div id="chat" class=" grid grid-cols-12 gap-y-2">

                            @if (isset($messages) && $messages->count() > 0)
                                @foreach ($messages as $message)
                                    @if ($message->email == auth()->user()->email)
                                        <x-SentMessage :message="$message"/>
                                    @else
                                        <x-recevedMessage :message="$message" />
                                    @endif
                                @endforeach
                               
                            @else
                                <div id="empty" class="col-start-1 col-end-13 h-96">
                                    <div class="flex items-center justify-center w-full h-full">
                                       there is no messages
                                    </div>
                                </div>
                            @endif

                               
                             
                        </div>
                    </div>
                    <!--! end chat content -->
                    @isset($messages)
                        <!--! start chat footer -->
                        <div class="h-auto relative -top-20 mb-10 rounded-xl bg-white  p-2">
                            <div class="flex  min-h-0">
                                <input id="imgUpload" type="file" onchange="sendImg(this);"  accept="image/gif, image/jpeg, image/png" name="" id="" class="invisible w-0">
                                <button onclick="selectImg()" class="flex m-1 items-center justify-center text-gray-400 hover:text-gray-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13">
                                        </path>
                                    </svg>

                                </button>
                                <button id ="emojiButton" onclick="selectEmoji()" class="flex relative m-1 items-center justify-center text-gray-400 hover:text-gray-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                        </path>
                                    </svg>
                                    <div id="emojiSelector" class="flex flex-wrap rounded-lg absolute   bg-indigo-300 "> </div>
                                </button>
                            
                                <div class=" flex flex-row-reverse ml-auto py-1">

                                    <!-- send -->
                                    <button type="submit" name="send" form="input-form"
                                        class="flex items-center justify-center bg-indigo-500 hover:bg-indigo-600 rounded-xl text-white m-1 px-3 py-3 flex-shrink-0">
                                        <svg class="w-4 h-4 transform rotate-45 -mt-px" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8">
                                            </path>
                                        </svg>
                                
                                    </button>
                                    <!-- microphone -->
                                    <button onclick="recordAudio()"
                                        class="flex relative items-center justify-center bg-indigo-500 hover:bg-indigo-600 rounded-xl text-white m-1 px-3 py-3 flex-shrink-0">
                                        <svg class="w-4 h-4 " xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" 
                                            viewBox="0 0 350 350" xml:space="preserve">
                                        
                                            <defs>
                                            </defs>
                                            <g id="icon"
                                                style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;"
                                                transform="translate(-1.9444444444444287 -1.9444444444444287) scale(3.89 3.89)">
                                                <path
                                                    d="M 49.092 43.729 h -8.184 c -6.752 0 -12.246 -5.494 -12.246 -12.246 V 12.246 C 28.663 5.494 34.156 0 40.908 0 h 8.184 c 6.752 0 12.246 5.494 12.246 12.246 v 19.238 C 61.338 38.236 55.844 43.729 49.092 43.729 z M 40.908 2.967 c -5.117 0 -9.279 4.162 -9.279 9.279 v 19.238 c 0 5.117 4.162 9.279 9.279 9.279 h 8.184 c 5.116 0 9.279 -4.162 9.279 -9.279 V 12.246 c 0 -5.117 -4.163 -9.279 -9.279 -9.279 H 40.908 z"
                                                    style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(255, 255, 255); fill-rule: nonzero; opacity: 1;"
                                                    transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                                                <path
                                                    d="M 46.483 57.161 h 3.716 c 13.222 0 23.979 -10.757 23.979 -23.979 c 0 -0.82 -0.664 -1.484 -1.484 -1.484 s -1.484 0.664 -1.484 1.484 c 0 11.586 -9.426 21.012 -21.012 21.012 H 39.802 c -11.586 0 -21.012 -9.426 -21.012 -21.012 c 0 -0.82 -0.664 -1.484 -1.484 -1.484 s -1.484 0.664 -1.484 1.484 c 0 13.222 10.757 23.979 23.979 23.979 h 3.715 v 29.457 c 0 0.145 0.027 0.283 0.066 0.415 h -9.571 c -0.82 0 -1.484 0.664 -1.484 1.484 S 33.193 90 34.012 90 h 21.975 c 0.819 0 1.484 -0.664 1.484 -1.484 s -0.664 -1.484 -1.484 -1.484 h -9.57 c 0.039 -0.133 0.066 -0.27 0.066 -0.415 V 57.161 z"
                                                    style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1;"
                                                    transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                                            </g>
                                        </svg>
                                        <div id="recording" class="hidden">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px"
                                                viewBox="0 0 100 125" style="enable-background:new 0 0 100 100;" xml:space="preserve">
                                                <g>
                                                    <path class="squiggly-line"
                                                        d="M91.2,44.8c-3.2,0-4.7,2.5-6.1,4.6c-1.2,2-2.3,3.7-4.4,3.7s-3.1-1.7-4.4-3.7c-1.4-2.2-2.9-4.6-6.1-4.6   c-3.2,0-4.7,2.5-6.1,4.6c-1.2,2-2.3,3.7-4.4,3.7c-2.1,0-3.1-1.7-4.4-3.7c-1.4-2.2-2.9-4.6-6.1-4.6c-3.2,0-4.7,2.5-6.1,4.6   c-1.2,2-2.3,3.7-4.4,3.7c-2,0-3.1-1.7-4.4-3.7c-1.4-2.2-2.9-4.6-6.1-4.6c-3.2,0-4.7,2.5-6.1,4.6c-1.2,2-2.3,3.7-4.4,3.7   c-2,0-3.1-1.7-4.4-3.7c-1.4-2.2-2.9-4.6-6.1-4.6c-0.6,0-1,0.4-1,1s0.4,1,1,1c2,0,3.1,1.7,4.4,3.7c1.4,2.2,2.9,4.6,6.1,4.6   c3.2,0,4.7-2.5,6.1-4.6c1.2-2,2.3-3.7,4.4-3.7s3.1,1.7,4.4,3.7c1.4,2.2,2.9,4.6,6.1,4.6c3.2,0,4.7-2.5,6.1-4.6   c1.2-2,2.3-3.7,4.4-3.7c2.1,0,3.1,1.7,4.4,3.7c1.4,2.2,2.9,4.6,6.1,4.6c3.2,0,4.7-2.5,6.1-4.6c1.2-2,2.3-3.7,4.4-3.7   c2.1,0,3.1,1.7,4.4,3.7c1.4,2.2,2.9,4.6,6.1,4.6s4.7-2.5,6.1-4.6c1.2-2,2.3-3.7,4.4-3.7c0.6,0,1-0.4,1-1S91.8,44.8,91.2,44.8z" />
                                        
                                        
                                                </g>
                                        
                                            </svg>
                                        </div>
                                    </button>

                                    <!-- call -->
                                    <button onclick="calling('vo')"
                                        class="flex items-center justify-center bg-indigo-500 hover:bg-indigo-600 rounded-xl text-white m-1 px-3 py-3 flex-shrink-0">
                                        
                                        
                                        <svg  version="1.1" x="0px" y="0px" width="15" height="15" 
                                            viewBox="0 0 100 100"  style="enable-background:new 0 0 96 96;" xml:space="preserve">
                                            <path fill="#ffffff" 
                                                d="M26.4,14c0.6,0,1.3,0.1,1.9,0.2l0.1,0l0.1,0c0.3,0,0.6,0.1,1,0.2l4.8,21.1l-6.4,3.3l-1.6,0.8l0.6,1.6  c2.2,6.2,5.8,11.9,10.9,17c4.6,4.7,10.5,8.5,17.1,10.8l1.6,0.6l0.8-1.6l3.3-6.4l21,4.8c0.1,0.3,0.2,0.7,0.2,1  c0.1,0.8,0.2,1.5,0.2,2.2c0,7-5.4,12.4-12.4,12.4c-14.9,0-28.9-5.8-39.3-16.3C19.8,55.3,14,41.3,14,26.4C14,19.4,19.4,14,26.4,14   M26.4,12c-8,0-14.4,6.4-14.4,14.4c0,15.9,6.4,30.3,16.9,40.7C39.3,77.6,53.7,84,69.6,84c8,0,14.4-6.4,14.4-14.4  c0-0.8-0.1-1.6-0.2-2.4c-0.1-0.8-0.4-1.6-0.6-2.4l-23.7-5.4l-4,7.8c-6.2-2.2-11.8-5.7-16.3-10.3S31,46.8,28.8,40.6l7.8-4l-5.4-23.7  c-0.8-0.3-1.6-0.5-2.4-0.6C28,12.1,27.2,12,26.4,12L26.4,12z" />
                                        </svg>
                                        
                                    </button>
                                    <!-- video -->
                                    <button  onclick="calling('vid')"
                                        class="flex items-center justify-center bg-indigo-500 hover:bg-indigo-600 rounded-xl text-white m-1 px-3 py-3 flex-shrink-0">
                                    
                                    
                                        <svg  version="1.1" x="0px" y="0px" width="15" height="15" 
                                            viewBox="0 0 100 100"  style="enable-background:new 0 0 96 96;" xml:space="preserve">
                                            <path fill="#ffffff" 
                                                style="font-size:medium;font-style:normal;font-variant:normal;font-weight:normal;font-stretch:normal;text-indent:0;text-align:start;text-decoration:none;line-height:normal;letter-spacing:normal;word-spacing:normal;text-transform:none;direction:ltr;writing-mode:lr-tb;text-anchor:start;opacity:1;fill-opacity:1;stroke:none;stroke-width:3.99999976000000010;marker:none;visibility:visible;display:inline;overflow:visible;enable-background:accumulate;font-family:Sans;-inkscape-font-specification:Sans"
                                                d="M 15 25 C 10.048512 25 6 29.048512 6 34 L 6 66 C 6 70.951488 10.048512 75 15 75 L 65 75 C 69.951488 75 74 70.951488 74 66 L 74 61 L 77.3125 61 L 90.75 71.5625 A 2.0001999 2.0001999 0 0 0 94 70 L 94 30 A 2.0001999 2.0001999 0 0 0 91.9375 28 A 2.0001999 2.0001999 0 0 0 90.75 28.4375 L 77.3125 39 L 74 39 L 74 34 C 74 29.048512 69.951488 25 65 25 L 15 25 z M 15 29 L 65 29 C 67.804676 29 70 31.195324 70 34 L 70 40.84375 A 2.0002 2.0002 0 0 0 70 41 L 70 59 A 2.0002 2.0002 0 0 0 70 59.1875 L 70 66 C 70 68.804676 67.804676 71 65 71 L 15 71 C 12.195324 71 10 68.804676 10 66 L 10 34 C 10 31.195324 12.195324 29 15 29 z M 90 34.125 L 90 65.875 L 80 58.03125 L 80 41.96875 L 90 34.125 z M 29.875 36 A 2.0001998 2.0001998 0 0 0 28 38 L 28 50 L 28 62 A 2.0001998 2.0001998 0 0 0 31.03125 63.71875 L 41.03125 57.71875 L 51.03125 51.71875 A 2.0001998 2.0001998 0 0 0 51.03125 48.28125 L 41.03125 42.28125 L 31.03125 36.28125 A 2.0001998 2.0001998 0 0 0 29.875 36 z M 32 41.53125 L 38.96875 45.71875 L 46.09375 50 L 38.96875 54.28125 L 32 58.46875 L 32 50 L 32 41.53125 z M 74 43 L 76 43 L 76 57 L 74 57 L 74 43 z " />
                                        </svg>
                                        
                                    </button>
                                </div>
                            </div>
                            <div class='perss-enter-key' onKeypress='submitForm(e)'></div>
                            <form id="input-form" method='post' class="flex-grow ml-1  min-h-0">
                                @csrf
                                <div class="w-full  min-h-0">
                                    <input type="hidden" id="currentConversation" name="currentConversation" value="{{session()->get('currentConversations')}}">
                                        <textarea dir="auto" name="message" id="inputText" type="text" style=' resize: none;'
                                            autocapitalize='sentences'
                                            oninput="auto_grow(this)"
                                            class="flex break-all w-full overflow-hidden p-2 border rounded-xl min-h-full focus:outline-none focus:border-indigo-300 pl-4 h-10" ></textarea>
                                
                                </div>
                            </form>
                        
                        </div>
                        <!--! end chat footer -->
                    @endisset
                  

                </div>
            </div>
            <!--! end chat body -->

        </div>
        <div id="voiceCalling" class="absolute hidden w-full h-full z-50 bg-indigo-400 "></div>
        <div id="vedioCalling" class="absolute hidden w-full h-full z-50 bg-indigo-400"></div>

    </div>
@endsection