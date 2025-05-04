<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex justify-center">
            All the registered Users
        </h2>
    </x-slot>
    <div class="py-2">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            @if ($users->isEmpty())
            <p class="p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg text-md flex justify-center">
                There is no user registered yet!</p>
            @endif
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <table class="table-auto border-collapse border mx-auto py-2 w-full text-center">
                    <thead class="bg-gray400">
                        <tr class="bg-gray-400">
                            <th class="px-4 py-2 border">ID</th>
                            <th class="px-4 py-2 border">Name</th>
                            <th class="px-4 py-2 border">Email</th>
                            <th class="px-4 py-2 border">Role</th>
                            <th class="px-4 py-2 border">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td class="px-4 py-2 border">{{$user->id}}</td>
                            <td class="px-4 py-2 border">{{$user->name}}</td>
                            <td class="px-4 py-2 border">{{$user->email}}</td>
                            <td class="px-4 py-2 border">
                                @php
                                    if ($user->role == 0) {
                                        echo "User";
                                    }else{
                                        echo "Admin";
                                    }
                                @endphp
                            </td>
                            <td class="px-4 py-2 border">
                                <a href="{{route('profile.view', $user->id)}}" class="flex items-center justify-center font-semibold">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                        <path fill-rule="evenodd" d="M15.75 2.25H21a.75.75 0 0 1 .75.75v5.25a.75.75 0 0 1-1.5 0V4.81L8.03 17.03a.75.75 0 0 1-1.06-1.06L19.19 3.75h-3.44a.75.75 0 0 1 0-1.5Zm-10.5 4.5a1.5 1.5 0 0 0-1.5 1.5v10.5a1.5 1.5 0 0 0 1.5 1.5h10.5a1.5 1.5 0 0 0 1.5-1.5V10.5a.75.75 0 0 1 1.5 0v8.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V8.25a3 3 0 0 1 3-3h8.25a.75.75 0 0 1 0 1.5H5.25Z" clip-rule="evenodd" />
                                    </svg>
                                    &nbsp;Visit
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4 py-2">
                    {{{ $users->links() }}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>