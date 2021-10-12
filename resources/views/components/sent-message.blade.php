
    <div class="sent col-start-2 col-end-13 p-2 rounded-lg">
        <div class="flex items-center justify-start flex-row-reverse">
            <div
                class="flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 flex-shrink-0">
                {{$firstLitter}}
            </div>
            <div class="relative mr-3 break-all text-sm bg-indigo-100 py-4 px-4 shadow rounded-xl">
                <form class="message relative">
                        <input type="hidden" name='msg_id' value="{{$message->msg_id}}">
                        <input type="hidden" name="type" value="{{$message->type}}">
                        <input type="hidden" name="size" value="{{$message->size}}">
                    @php
                        $msg = $message->text ? $message->text : $message->path;
                    @endphp
                    <x-Message :type="$message->type" :message="$msg" :size="$message->size"/>
                    
                </form >

                    <div class="status absolute text-xs bottom-0 right-0 -mb-1 mr-2 text-gray-500">
                        @if ($message->is_read)
                        <div class='read'><svg  viewBox="0 0 30 30" width="20"f fill="#4338CA"  height="20" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M24 6.278l-11.16 12.722-6.84-6 1.319-1.49 5.341 4.686 9.865-11.196 1.475 1.278zm-22.681 5.232l6.835 6.01-1.314 1.48-6.84-6 1.319-1.49zm9.278.218l5.921-6.728 1.482 1.285-5.921 6.756-1.482-1.313z"/></svg></div>
                        @else
                        <div class='unread'><svg   viewBox="0 0 30 30" width="20"f fill="#4338CA"  height="20" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M21 6.285l-11.16 12.733-6.84-6.018 1.319-1.49 5.341 4.686 9.865-11.196 1.475 1.285z"/></svg></div>
                        @endif
                    </div>
                     {{-- <div class="absolute text-xs bottom-0 right-0 -mb-5 mr-2 text-gray-500">
                        <div id="spinner" class='spinner border-2   rounded-full w-4 h-4'></div>
                    </div> --}}
             
            </div>
        </div>
    </div>
