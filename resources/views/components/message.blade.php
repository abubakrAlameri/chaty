@if ($type == 'text')
 
    {{$message}}  
@else
    <button name="download" class="absolute flex flex-col justify-center items-center w-full h-full bg-white opacity-100 z-10">
        <svg class="w-10 h-10" viewBox = "0 0 100 100"  >
            <circle style="transition: 0.5s linear" class="" cx="50" cy="50" stroke="#4338CA" r="40" fill="transparent" stroke="#4338CA" stroke-width="4" />
            <path stroke="#4338CA" stroke-width="3" transform="translate(40,40)" d="M11 21.883l-6.235-7.527-.765.644 7.521 9 7.479-9-.764-.645-6.236 7.529v-21.884h-1v21.883z"/>
        </svg>
        <p class="text-xs text-gray-500">{{$type}}</p>
        
    </button>
    <input type="hidden" name="path" value="{{asset('storage/' . $message)}}">

   @if ($type == 'image')
       
        <img  src="#" width="190" height="200">
    @elseif($type == 'audio')

        <audio style="width: 190px" controls>
            <source src="#" >
        </audio>
    @elseif($type == 'video') 

        <video width="190" height="200"  poster preload controls>
            <source src="#" >
        </video>
    @elseif($type == 'document') 

        <a href="#" download="download" class="flex items-center justify-center w-36 rounded border-indigo-300" style="border-width: 1px">
            <div class="w-1/4  p-1 ">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#4338CA"><path d="M11.362 2c4.156 0 2.638 6 2.638 6s6-1.65 6 2.457v11.543h-16v-20h7.362zm.827-2h-10.189v24h20v-14.386c0-2.391-6.648-9.614-9.811-9.614z"/></svg>
            </div>
            <div class="w-2/3 text-gray-400 border-l-2 border-indigo-300 pl-4  p-1 " style="border-left-width: 1px">
                <p class="text-sm">FILE</p>
                <p class="text-xs">{{$humenSize}}</p>
            </div>
        </a>
    @endif
@endif
 
