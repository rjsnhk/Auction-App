<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Auction | {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased dark:bg-black dark:text-white/50">
    <div className="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
        @include('layouts.navigation')
        <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
            <img src="{{asset('pexels-karolina-grabowska-4862892.jpg')}}" alt="" class="absolute inset-0 -z-10 h-full w-full object-cover object-right md:object-center">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                @php
                    $products = DB::table('products')->select('name','picture', 'description', 'starting_price')->where('id', $auction->product_id)->get();
                        foreach ($products as $product) {
                        }
                @endphp
                <main class="mt-6">
                    <div class="relative flex w-full items-center overflow-hidden rounded bg-white px-4 pb-8 pt-14 shadow-2xl sm:px-6 sm:pt-8 md:p-6 lg:p-8">
                        <div class="w-full shadow rounded bg-gray-50">
                            <h2 class="text-xl py-4 font-bold bg-gray-200 rounded text-gray-900 sm:pr-12 text-center">
                                {{ $auction->name }}
                            </h2>
                            <div class="aspect-h-1 aspect-w-3 overflow-hidden rounded-lg bg-gray-100 sm:col-span-4 lg:col-span-5">
                                <img src="{{ asset($product->picture) }}"
                                    alt="picture of {{ $auction->name }}'s auction"
                                    class="object-center" style="object-fit:contain;">
                            </div>
                            <div class="sm:col-span-8 lg:col-span-7">
                                <a href="{{route('product.show', $auction->product_id)}}" class="text-md sm:pr-12">
                                    @php
                                        $details = substr($product->description, 0, strlen($product->description)/3).".....View more";
                                    @endphp
                                    <p class="text-md bg-gray-200 text-gray-900"> <b>Details:</b> {{ $details }} </p>
                                </a>
                                {{--auction information--}}
                                <section aria-labelledby="information-heading" class="mt-2">
                                    <h3 id="information-heading" class="sr-only">Auction information</h3>
                                    <div class="flex justify-between">
                                        <p class="text-md text-gray-900"> <b>Host:</b>
                                            <a href="{{route('profile.view', $auction->host_id)}}">
                                                {{DB::table('users')->where('id', $auction->host_id)->value('name')}}
                                            </a> 
                                        </p>
                                        <p class="text-md text-gray-900"> <b>Starting Price: </b> BDT {{$product->starting_price}}</p>
                                    </div>
                                    <div class="mt-4 flex justify-between">
                                        <p class="text-md text-gray-900"> <b>Start:</b> {{$auction->start_time}}</p>
                                        <p class="text-md text-gray-900"> <b>End: </b> {{$auction->end_time}}</p>
                                    </div>
                                    <div class="mt-4 flex justify-between">
                                        <p class="text-md"> <b> Number of bid: </b> {{$auction->no_of_bid}}</p>
                                        <p class="text-md"> <b> Last bidder: </b>
                                            @if ($auction->no_of_bid == 0)
                                                {{"N/A"}}
                                            @endif
                                            <a href="{{route('profile.view', $auction->owner_id)}}">
                                                {{DB::table('users')->where('id', $auction->owner_id)->value('name')}}
                                            </a>
                                        </p>
                                    </div>
                                </section>
                                @if (session('status'))
                                    <div class="text-md w-full text-center my-2 py-2 text-red" style="color: red;">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                {{-- Bidding process --}}
                                <section aria-labelledby="bidding-heading" class="mt-6">
                                    <h3 id="bidding-heading" class="sr-only">bidding options</h3>
                                    {{-- Auction finished --}}
                                    @if ($auction->end_time <= date('Y-m-d H:i:s') && $auction->status != 0)
                                        {{-- Product sold --}}
                                        @if ($auction->no_of_bid > 0)
                                            <p class="text-md flex items-center justify-center">
                                                <b> Winner of this action: </b>
                                                <a href="{{route('profile.view', $auction->owner_id)}}" class="ms-2 py-2 text-md font-bold flex items-center">
                                                    {{DB::table('users')->where('id', $auction->owner_id)->value('name')}}
                                                </a>
                                            </p>
                                            {{-- Payment procedure --}}
                                            @auth
                                                @if (Auth::user()->id == $auction->owner_id)
                                                    @if ($auction->payment == 0)
                                                        <a href="{{route('payment.pay', $auction->id)}}" class="mt-6 flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-8 py-3 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Payment for {{$product->name}}</a>
                                                    @elseif ($auction->payment == 1)
                                                        <h3 class="text-md py-4 font-medium text-gray-900 text-center"> Your payment is done. Please wait for delivery. </h3>
                                                    @endif
                                                @elseif (Auth::user()->id == $auction->host_id)
                                                    @if ($auction->payment == 0)
                                                        <h3 class="text-md py-4 font-medium text-gray-900 text-center"> Your product is sold. Please wait for get paid. </h3>
                                                    @elseif($auction->payment == 1)
                                                        @php
                                                            $withdraw = DB::table('payments')->where('id', $auction->payment_id)->value('withdrawer');
                                                        @endphp
                                                        @if ($withdraw == 0)
                                                            <a href="{{route('payment.withdraw', $auction->id)}}" class="mt-6 flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-8 py-3 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Withdraw for {{$product->name}}</a>
                                                        @endif
                                                    @endif
                                                @endif
                                            @endauth
                                                <p class="mt-6 flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-8 py-3 text-base font-medium text-white">Product Sold</p>
                                        @else
                                            <p type="submit" class="mt-6 flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-8 py-3 text-base font-medium text-white">Unsold</p>
                                        @endif
                                        <h3 class="text-md mt-4 font-medium text-gray-900 text-center"><b>Last Price of this product: </b>BDT {{$auction->final_price}}</h3>
                                    @endif
                                    {{-- Auction ongoing --}}
                                    @if ($auction->start_time <= date('Y-m-d H:i:s') && $auction->end_time >= date('Y-m-d H:i:s'))
                                        @auth
                                            @if (Auth::user()->id != $auction->host_id && Auth::user()->role == '0')
                                                <form action="{{route('auction.update', $auction->id)}}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                    <div class="mt-4">
                                                        <div class="flex items-center justify-between">
                                                            <h3 class="text-md font-medium text-gray-900"><b>Last Price: </b>BDT {{$auction->final_price}}</h3>
                                                            <input type="number" name="final_price" min="{{$auction->final_price}}" id="final_price" autocomplete="final_price"
                                                            class="w-8xl rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Offer your price here"
                                                            @if ($auction->start_time > date('Y-m-d H:i:s'))
                                                                readonly
                                                            @endif>
                                                            <x-input-error :messages="$errors->get('final_price')" class="mt-2" />
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="mt-6 flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-8 py-3 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Bid price</button>
                                                </form>
                                            @else
                                                <p class="mt-6 flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-8 py-3 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                                    It's online, wait for finish.
                                                </p>
                                            @endif
                                        @else
                                            <a href="{{route('login')}}" class="mt-6 flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-8 py-3 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Auction is ongoing, Log in to join</a>
                                        @endauth
                                    @endif
                                </section>
                                {{-- Review --}}
                                @if ($auction->status == 2)
                                    <section aria-labelledby="review-heading" class="mt-6">
                                        <h3 id="review-heading" class="sr-only">review options</h3>
                                        {{--create review--}}
                                        @if ($auction->massage == null)
                                            @auth
                                                @if (Auth::user()->id == $auction->owner_id)
                                                    <form action="{{route('payment.review', $auction->id)}}" method="post" class="mx-auto mt-6 max-w-xl sm:mt-10">
                                                        @csrf
                                                        @method('put')
                                                        <div class="sm:col-span-2">
                                                            <label for="message" class="block text-sm font-semibold leading-6 text-gray-900">Message</label>
                                                            <div class="mt-2">
                                                                <textarea name="message" id="message" rows="4" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" autofocus placeholder="Express your thought about this product"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="flex items-center justify-start mt-4">
                                                            <x-primary-button>
                                                                {{ __('Submit review') }}
                                                            </x-primary-button>
                                                        </div>
                                                    </form>
                                                @elseif (Auth::user()->id == $auction->host_id)
                                                    <h3 class="text-md py-4 font-medium text-gray-900 text-center"> Payment is done. Please wait for get review from buyer. </h3>
                                                @endif
                                            @endauth
                                        {{--show the review--}}
                                        @else
                                            <div class="mt-2">
                                                @php
                                                    $avatar = DB::table('users')->where('id', $auction->owner_id)->value('avatar');
                                                    $owner_name = DB::table('users')->where('id', $auction->owner_id)->value('name');
                                                @endphp
                                                <h3 class="px-2 text-xl font-medium text-gray-900">Feedback from buyer:</h3>
                                                <a href="{{route('profile.view', $auction->owner_id)}}" class="mt-2 ms-2 py-2 text-md font-bold flex items-center">
                                                    @if ($avatar == null)
                                                        <svg class="h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                            <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" clip-rule="evenodd" />
                                                        </svg>
                                                    @else
                                                        <img class="h-12 w-12 rounded-full" src="{{asset($avatar)}}" alt="{{$owner_name}}'s photo">
                                                    @endif
                                                    &nbsp;{{$owner_name}}:
                                                </a>
                                                <div name="message" id="message" rows="4" class="block w-full rounded-md px-4 py-2 text-gray-900 shadow-sm ">
                                                    {{$auction->massage}}
                                                </div>
                                            </div>
                                        @endif
                                    </section>
                                @endif
                            </div>
                        </div>
                    </div>
                </main>

                <footer class="py-16 text-center text-sm text-black dark:text-white/70">
                    Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                </footer>
            </div>
        </div>
    </div>
</body>
</html>