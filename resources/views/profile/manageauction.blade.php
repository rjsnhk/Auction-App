<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex justify-center">
            Manage auctions
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
                        <div class="p-6 m-4 text-gray-900 dark:text-gray-100">
                            <p>
                                <div class="text-lg">{{$auction->name}}</div>
                                <div class="text-sm">
                                    <span> Status:</span>
                                    @if ($auction->status == 0)
                                        {{ "On observation" }}
                                    @elseif ($auction->status == 1)
                                        {{ "Online" }}
                                    @elseif ($auction->status == 2)
                                        {{ "Finished" }}
                                    @else
                                        {{ "Request deny" }}
                                    @endif
                                </div>
                                @if ($auction->status != 1 && $auction->massage != null)
                                    <div class="text-md mt-2" style="color:red;">
                                        "{{ $auction->massage }}"
                                    </div>
                                @endif
                            </p>
                        </div>
                        <div class="p-4 text-gray-900 dark:text-gray-100 flex">
                            <a href="{{route('auction.show', $auction->id)}}">
                                <x-primary-button class="ms-4">
                                    {{ __('View') }}
                                </x-primary-button>
                            </a>
                            <form action="{{route('auction.destroy', $auction->id)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <x-danger-button class="ms-4">
                                    {{ __('Delete') }}
                                </x-danger-button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
