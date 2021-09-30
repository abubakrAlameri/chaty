<div class="receved col-start-1 col-end-12 md:col-end-8 p-2 rounded-lg">
    <div class="flex flex-row items-center">
        <div
            class="flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 flex-shrink-0">
            {{ $firstLitter }}
        </div>
        <div class="relative ml-3 text-sm break-all bg-white py-4 px-4 shadow rounded-xl">
            <div>
                    {{$message->text}}
            </div>
        </div>
    </div>
</div>