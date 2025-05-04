<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex justify-center">
            User Messages for contact
        </h2>
        @if (session('status'))
            <div class="flex justify-center m-2 p-2 text-md">
                {{ session('status') }}
            </div>
        @endif
    </x-slot>
    <div class="py-2">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            @if ($contacts->isEmpty())
                <p class="p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg text-md flex justify-center">There is nothing to do here!</p>
            @endif
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg grid lg:grid-cols-3">
                @foreach ($contacts as $contact)
                    <div class="shadow">
                        <div class="p-6 m-4 text-gray-900 dark:text-gray-100">
                            <p class="text-md">
                                <div class="flex justify-between">
                                    <div>
                                        <span class="font-semibold">No: </span>
                                        <span>{{$contact->id}}</span>
                                    </div>
                                    @if ($contact->status == 0)
                                        <a href="{{route('contact.show', $contact->id)}}">
                                            <x-primary-button class="ms-4">
                                                {{ __('Mark as read') }}
                                            </x-primary-button>
                                        </a>
                                    @else
                                        <form action="{{route('contact.destroy', $contact->id)}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <x-danger-button class="ms-4">
                                                {{ __('Delete') }}
                                            </x-danger-button>
                                        </form>
                                    @endif
                                </div>
                                <div>
                                    <span class="font-semibold">From: </span>
                                    <span>{{$contact->first_name.' - '.$contact->last_name}}</span>
                                </div>
                                <div>
                                    <span class="font-semibold">Email: </span>
                                    <span>{{$contact->email}}</span>
                                </div>
                                <div class="font-semibold">Message:</div>
                                <div>{{$contact->message}}</div>
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
