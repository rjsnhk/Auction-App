<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex justify-center">
            Manage auctions request
        </h2>
    </x-slot>
    <div class="py-2">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            @if ($auctions->isEmpty())
                <p class="p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg text-md flex justify-center">There is nothing to do here!</p>
            @endif
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg grid lg:grid-cols-3">
                @foreach ($auctions as $auction)
                    <div class="shadow">
                        <div class="m-4 text-gray-900 dark:text-gray-100">
                            <p>
                                <div class="text-lg">
                                    <b>Name:&nbsp;</b>
                                    {{$auction->name}}
                                </div>
                                <div class="text-sm flex">
                                    <b>Price:&nbsp;</b>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="gray" class="w-5 h-5">
                                        <path fill-rule="evenodd" d="M12 21.75c5.385 0 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25 2.25 6.615 2.25 12s4.365 9.75 9.75 9.75ZM10.5 7.963a1.5 1.5 0 0 0-2.17-1.341l-.415.207a.75.75 0 0 0 .67 1.342L9 7.963V9.75h-.75a.75.75 0 1 0 0 1.5H9v4.688c0 .563.26 1.198.867 1.525A4.501 4.501 0 0 0 16.41 14.4c.199-.977-.636-1.649-1.415-1.649h-.745a.75.75 0 1 0 0 1.5h.656a3.002 3.002 0 0 1-4.327 1.893.113.113 0 0 1-.045-.051.336.336 0 0 1-.034-.154V11.25h5.25a.75.75 0 0 0 0-1.5H10.5V7.963Z" clip-rule="evenodd" />
                                    </svg>
                                    &nbsp;{{$auction->final_price}}
                                </div>
                                <div class="text-md mt-2">
                                    <b>Host:&nbsp;</b>
                                    {{DB::table('users')->where('id', $auction->host_id)->value('name')}}
                                </div>
                            </p>
                            <div class="aspect-h-1 aspect-w-3 m-2 rounded-lg lg:block">
                                <img src="{{asset(DB::table('products')->where('id', $auction->product_id)->value('picture'))}}"
                                    alt="{{ $auction->name }}'s photo"
                                    class="h-full w-full object-cover object-center">
                            </div>
                        </div>
                        <div class="p-4 text-gray-900 dark:text-gray-100 flex justify-start">
                            <div class="py-2 grid grid-cols-1">
                                <a href="{{route('auction.show', $auction->id)}}">
                                    <x-primary-button>
                                        {{ __('View') }}
                                    </x-primary-button>
                                </a>
                                <a href="{{route('admin.accept', $auction->id)}}" class="mt-4">
                                    <x-primary-button>
                                        {{ __('Accept') }}
                                    </x-primary-button>
                                </a>    
                            </div>
                            <form action="{{route('admin.deny', $auction->id)}}" method="POST" class="mx-auto mt-2 max-w-xl p-s-2">
                                @csrf
                                @method('patch')
                                <div class="sm:col-span-2">
                                    <input type="text" name="massage" id="massage" required autocomplete="massage" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Explain why you deny...">
                                </div>
                                <x-danger-button class="mt-2">
                                    {{ __('Deny') }}
                                </x-danger-button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
