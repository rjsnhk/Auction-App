<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex justify-center">
            Create an auction
        </h2>
    </x-slot>
    <div class="py-2">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @php
                        $name = $product->name."'s auction";
                    @endphp
                    <form method="POST" action="{{ route('auction.store') }}">
                        @csrf

                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text"
                                            name="name" value="{{ $name }}"
                                            readonly title="this field is not for edit" autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Price -->
                        <div class="mt-4">
                            <x-input-label for="final_price" :value="__('Price')" />
                            <x-text-input id="final_price" class="block mt-1 w-full" type="number"
                                            name="final_price" value="{{$product->starting_price}}"
                                            readonly title="this field is not for edit" autocomplete="final price" />
                            <x-input-error :messages="$errors->get('final_price')" class="mt-2" />
                        </div>

                        <!-- Product -->
                        <div class="mt-4">
                            <x-input-label for="product" :value="__('Product ID')" />
                            <x-text-input id="product" class="block mt-1 w-full" type="number"
                                            name="product" value="{{$product->id}}"
                                            readonly title="this field is not for edit" autocomplete="product" />
                            <x-input-error :messages="$errors->get('product')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-start mt-4">
                            <x-primary-button class="ms-4">
                                {{ __('Create Auction') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
