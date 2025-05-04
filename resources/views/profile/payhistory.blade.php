<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex justify-center">
            All the payment history
        </h2>
    </x-slot>
    <div class="py-2">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            @if (!$payments->isEmpty())
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <table class="table-auto border-collapse border mx-auto py-2 w-full text-center">
                        <thead class="bg-gray400">
                            <tr class="bg-gray-400">
                                <th class="px-4 py-2 border">ID</th>
                                <th class="px-4 py-2 border">Auction no</th>
                                <th class="px-4 py-2 border">Payer</th>
                                <th class="px-4 py-2 border">Withdrawer</th>
                                <th class="px-4 py-2 border">Amount</th>
                                <th class="px-4 py-2 border">Commission</th>
                                <th class="px-4 py-2 border">Gateway</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($payments as $payment)
                            <tr>
                                <td class="px-4 py-2 border">{{$payment->id}}</td>
                                <td class="px-4 py-2 border">
                                    <a href="{{route('auction.show', $payment->auction_id)}}">{{$payment->auction_id}}</a>
                                </td>
                                <td class="px-4 py-2 border">
                                    <a href="{{route('profile.view', $payment->payer)}}">{{$payment->payer}}</a>
                                </td>
                                <td class="px-4 py-2 border">
                                    <a href="{{route('profile.view', $payment->withdrawer)}}">{{$payment->withdrawer}}</a>
                                </td>
                                <td class="px-4 py-2 border">{{$payment->amount}}</td>
                                <td class="px-4 py-2 border">{{$payment->commission}}</td>
                                <td class="px-4 py-2 border">{{$payment->gateway}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4 py-2">
                        {{{ $payments->links() }}}
                    </div>
                </div> 
            @else
                <p class="p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg text-md flex justify-center">
                    There is no payment history yet!
                </p>
            @endif
            
        </div>
    </div>
</x-app-layout>