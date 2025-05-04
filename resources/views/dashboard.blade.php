<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex justify-center">
            {{ Auth::user()->name; }}
        </h2>
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 grid gap-6 lg:grid-cols-3 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-center text-gray-900 dark:text-gray-100">
                    <h3 class="font-semibold text-gray-800 dark:text-gray-200 leading-tight">
                        {{ __("Number of sell") }}
                    </h3>
                    {{ Auth::user()->total_sell; }}
                </div>
                <div class="p-6 text-center text-gray-900 dark:text-gray-100">
                    <h3 class="font-semibold text-gray-800 dark:text-gray-200 leading-tight">
                        {{ __("Number of buy") }}
                    </h3>
                    {{ Auth::user()->total_buy; }}
                </div>
                <div class="p-6 text-center text-gray-900 dark:text-gray-100">
                    <h3 class="font-semibold text-gray-800 dark:text-gray-200 leading-tight">
                        {{ __("Number of bid") }}
                    </h3>
                    {{ Auth::user()->total_bid; }}
                </div>
            </div>
        </div>
        @if (session('status'))
            <div class="text-md w-full text-center">
                {{ session('status') }}
            </div>
        @endif
    </x-slot>

    <div class="py-2">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-2xl font-bold tracking-tight text-gray-900">Ongoing auction</h2>

                    <div class="mt-4 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                        @php
                            $auctions = DB::table('auctions')->where('status', '1')
                                                            ->where('start_time', '<=', date('Y-m-d H:i:s'))
                                                            ->where('end_time', '>=', date('Y-m-d H:i:s'))
                                                            ->get();
                            if($auctions->isEmpty()){
                                echo "<div class'text-md mt-4''> Nothing is auctioning now!<br> Please wait for upcoming auction. </div>";
                            }
                        @endphp
                        @foreach ($auctions as $auction)
                            <div class="group relative">
                                <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80">
                                    <img src="{{asset(DB::table('products')->where('id', $auction->product_id)->value('picture'))}}"
                                        alt="{{ $auction->name }}'s picture"
                                        class="h-full w-full object-cover object-center lg:h-full lg:w-full">
                                </div>
                                <div class="mt-4 flex justify-between">
                                    <div>
                                        <h3 class="text-md font-bold text-gray-700">
                                            <a href="{{ route('auction.show', $auction->id) }}">
                                                <span aria-hidden="true" class="absolute inset-0"></span>
                                                {{$auction->name}}
                                            </a>
                                        </h3>
                                        <p class="mt-1 text-sm text-gray-500">{{ DB::table('products')->where('id', $auction->product_id)->value('name') }}</p>
                                    </div>
                                    <p class="text-sm font-medium text-gray-900 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="correntcolor" class="w-6 h-6">
                                            <path fill-rule="evenodd" d="M12 21.75c5.385 0 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25 2.25 6.615 2.25 12s4.365 9.75 9.75 9.75ZM10.5 7.963a1.5 1.5 0 0 0-2.17-1.341l-.415.207a.75.75 0 0 0 .67 1.342L9 7.963V9.75h-.75a.75.75 0 1 0 0 1.5H9v4.688c0 .563.26 1.198.867 1.525A4.501 4.501 0 0 0 16.41 14.4c.199-.977-.636-1.649-1.415-1.649h-.745a.75.75 0 1 0 0 1.5h.656a3.002 3.002 0 0 1-4.327 1.893.113.113 0 0 1-.045-.051.336.336 0 0 1-.034-.154V11.25h5.25a.75.75 0 0 0 0-1.5H10.5V7.963Z" clip-rule="evenodd" />
                                        </svg>
                                        &nbsp;{{ $auction->final_price }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <h2 class="mt-6 text-2xl font-bold tracking-tight text-gray-900">Wined auction</h2>

                    <div class="mt-4 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                        @php
                            $auctions = DB::table('auctions')->where('status', '2')
                                                            ->where('owner_id', Auth::user()->id)
                                                            ->get();
                            if($auctions->isEmpty()){
                                echo "<div class'text-md mt-4''> Nothing to show here!<br> The auction you win will show here. </div>";
                            }
                        @endphp
                        @foreach ($auctions as $auction)
                            <div class="group relative">
                                <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80">
                                    <img src="{{asset(DB::table('products')->where('id', $auction->product_id)->value('picture'))}}"
                                        alt="{{ $auction->name }}'s picture"
                                        class="h-full w-full object-cover object-center lg:h-full lg:w-full">
                                </div>
                                <div class="mt-4 flex justify-between">
                                    <div>
                                        <h3 class="text-md font-bold text-gray-700">
                                            <a href="{{ route('auction.show', $auction->id) }}">
                                                <span aria-hidden="true" class="absolute inset-0"></span>
                                                {{$auction->name}}
                                            </a>
                                        </h3>
                                        <p class="mt-1 text-sm text-gray-500">{{ DB::table('products')->where('id', $auction->product_id)->value('name') }}</p>
                                    </div>
                                    <p class="text-sm font-medium text-gray-900 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="correntcolor" class="w-6 h-6">
                                            <path fill-rule="evenodd" d="M12 21.75c5.385 0 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25 2.25 6.615 2.25 12s4.365 9.75 9.75 9.75ZM10.5 7.963a1.5 1.5 0 0 0-2.17-1.341l-.415.207a.75.75 0 0 0 .67 1.342L9 7.963V9.75h-.75a.75.75 0 1 0 0 1.5H9v4.688c0 .563.26 1.198.867 1.525A4.501 4.501 0 0 0 16.41 14.4c.199-.977-.636-1.649-1.415-1.649h-.745a.75.75 0 1 0 0 1.5h.656a3.002 3.002 0 0 1-4.327 1.893.113.113 0 0 1-.045-.051.336.336 0 0 1-.034-.154V11.25h5.25a.75.75 0 0 0 0-1.5H10.5V7.963Z" clip-rule="evenodd" />
                                        </svg>
                                        &nbsp;{{ $auction->final_price }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
