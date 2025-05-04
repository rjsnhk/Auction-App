<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> Auctions | {{ config('app.name', 'Laravel') }}</title>

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
            <div class="relative bg-blend-normal w-full max-w-2xl px-6 lg:max-w-7xl">

                <main class="mt-4">
                    <!--ongoing auction-->
                    <div class="mx-auto max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-8">
                        <h2 class="text-2xl font-bold tracking-tight text-gray-900">Ongoing auction</h2>
                        <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
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
                                <div class="group relative bg-gray">
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
                    <!--upcoming auction-->
                    <div class="mx-auto max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-8">
                        <h2 class="text-2xl font-bold tracking-tight text-gray-900">Upcoming auction</h2>
                        <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                            @php
                                $auctions = DB::table('auctions')->where('status', '1')
                                                                ->where('start_time', '>=', date('Y-m-d H:i:s'))
                                                                ->get();
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
                    <!--finished auction-->
                    <div class="mx-auto max-w-2xl px-4 py-4 sm:px-6 sm:py-6 lg:max-w-7xl lg:px-8">
                        <h2 class="text-2xl font-bold tracking-tight text-gray-900">Finished auction</h2>

                        <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                            @php
                                $auctions = DB::table('auctions')->where('status', '2')
                                                                ->get();
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
                </main>

                <footer class="py-16 text-center text-sm text-black dark:text-white/70">
                    Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                </footer>
            </div>
        </div>
    </div>
</body>

</html>