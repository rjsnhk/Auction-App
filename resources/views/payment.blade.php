<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex justify-center">
            {{ Auth::user()->name; }}
        </h2>
    </x-slot>

    <div class="py-2">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="relative flex w-full items-center overflow-hidden bg-white px-4 pb-8 pt-14 shadow-2xl sm:px-6 sm:pt-8 md:p-6 lg:p-8">
                    @php
                        $products = DB::table('products')->select('name','picture')->where('id', $auction->product_id)->get();
                        foreach ($products as $product) {
                        }
                    @endphp
                    <div class="py-4 w-full gap-x-6 gap-y-8 lg:gap-x-8 shadow bg-gray-50">
                        <h2 class="text-xl py-4 font-bold bg-gray-200 rounded text-gray-900 sm:pr-12 text-center">
                            {{ $auction->name }}
                        </h2>
                        <div class="aspect-h-1 aspect-w-3 overflow-hidden rounded-lg bg-gray-100 sm:col-span-4 lg:col-span-5">
                            <img src="{{ asset($product->picture) }}"
                                alt="picture of {{ $auction->name }}'s auction"
                                class="object-center" style="object-fit:contain;">
                        </div>
                        <div class="sm:col-span-8 lg:col-span-7">
                            <section aria-labelledby="information-heading" class="mt-2">
                                <h3 id="information-heading" class="sr-only">Product information</h3>
                                <div class="flex justify-between">
                                    <p class="text-md text-gray-900"> <b>Product:</b> {{$product->name}}</p>
                                    <p class="text-md text-gray-900"> <b>Price: </b> BDT {{$auction->final_price}}</p>
                                </div>
                                <div class="mt-4 flex justify-between">
                                    <p class="text-md text-gray-900"> <b>Start:</b> {{$auction->start_time}}</p>
                                    <p class="text-md text-gray-900"> <b>End: </b> {{$auction->end_time}}</p>
                                </div>
                            </section>

                            {{-- Payment status --}}
                            <section aria-labelledby="options-heading" class="mt-6">
                                <h3 id="options-heading" class="sr-only">payment status</h3>
                                {{-- Auction finished --}}
                                @if (Auth::user()->id == $auction->host_id)
                                    <div class="mt-6 flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-8 py-3 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                        @if (session('status'))
                                            {{ session('status')}}
                                        @endif
                                    </div>
                                @elseif (Auth::user()->id == $auction->owner_id)
                                    <div class="mt-6 flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-8 py-3 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                        @if (session('status'))
                                            {{session('status')}}
                                        @endif
                                    </div>
                                @endif
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
