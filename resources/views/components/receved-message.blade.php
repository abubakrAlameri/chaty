<div class="receved col-start-1 col-end-12 md:col-end-8 p-2 rounded-lg">
    <div class="flex flex-row items-center">
        <div
            class="flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 flex-shrink-0">
            {{ $firstLitter }}
        </div>
        <div class="relative ml-3 text-sm break-all bg-white py-4 px-4 shadow rounded-xl">
             <form class="message relative">
                    <input type="hidden" name='msg_id' value="{{$message->msg_id}}">
                        <input type="hidden" name="type" value="{{$message->type}}">
                        <input type="hidden" name="size" value="{{$message->size}}">
                    @php
                        $msg = $message->text ? $message->text : $message->path;
                    @endphp
                    <x-Message :type="$message->type" :message="$msg" :size="$message->size"/>
                    
                </form >

        </div>
    </div>
</div>