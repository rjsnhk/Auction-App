<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex justify-center">
            Manage products for auction
        </h2>
        @if (session('status'))
            <div class="flex justify-center m-2 p-2 text-md">
                {{ session('status') }}
            </div>
        @endif
    </x-slot>
    
    <div class="py-2">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if ($products->isEmpty())
                        <p class="p-6 text-md flex justify-center">There is nothing to do here! Add product for manage.</p>
                    @endif
                    <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:gap-x-8">
                        @foreach ($products as $product)
                            <div class="shadow">
                                <div class="group relative">
                                    <div
                                        class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80">
                                        <img src="{{ asset($product->picture) }}"
                                            alt="{{$product->name}}, picture"
                                            class="h-full w-full object-cover object-center lg:h-full lg:w-full">
                                    </div>
                                    <div class="mt-4 flex justify-between">
                                        <div>
                                            <h3 class="text-sm text-gray-700">
                                                <a href="{{route('product.show', $product->id)}}">
                                                    <span aria-hidden="true" class="absolute inset-0"></span>
                                                    {{$product->name}}
                                                </a>
                                            </h3>
                                            <p class="mt-1 text-sm text-gray-500">{{$product->category}}</p>
                                        </div>
                                        <p class="text-sm font-medium text-gray-900">BDT {{$product->starting_price}}</p>
                                    </div>
                                </div>
                                <div class="p-2 text-gray-900 dark:text-gray-100 flex items-center">
                                    <a href="{{route('product.edit', $product->id)}}">
                                        <x-primary-button class="ms-4">
                                            {{ __('Update') }}
                                        </x-primary-button>
                                    </a>
                                    <form action="{{route('product.destroy', $product->id)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <x-danger-button class="ms-4">
                                            {{ __('Delete') }}
                                        </x-danger-button>
                                    </form>
                                    <a href="{{route('product.auction.create', $product->id)}}">
                                        <x-primary-button class="ms-4">
                                            {{ __('Add to auction') }}
                                        </x-primary-button>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
