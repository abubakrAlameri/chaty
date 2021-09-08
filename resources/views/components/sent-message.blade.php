
    <div class="sent col-start-2 col-end-13 p-2 rounded-lg">
        <div class="flex items-center justify-start flex-row-reverse">
            <div
                class="flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 flex-shrink-0">
                {{$firstLitter}}
            </div>
            <div class="relative mr-3 break-normal text-sm bg-indigo-100 py-2 px-4 shadow rounded-xl">
                <div>
                    {{$message->text}}
                </div>
                @if ($message->is_read)
                    <div class="absolute text-xs bottom-0 right-0 -mb-5 mr-2 text-gray-500">
                        Seen
                    </div>
                     {{-- <div class="absolute text-xs bottom-0 right-0 -mb-5 mr-2 text-gray-500">
                        <div id="spinner" class='spinner border-2   rounded-full w-4 h-4'></div>
                    </div> --}}
                @endif
            </div>
        </div>
    </div>
