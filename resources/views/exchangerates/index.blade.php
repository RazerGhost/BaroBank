<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-3xl font-bold">Welcome to your Table Page</h1>
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Currency From</th>
                            <th scope="col" class="px-6 py-3">Currency To</th>
                            <th scope="col" class="px-6 py-3">Rate</th>
                            <th scope="col" class="px-6 py-3">Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($exchangeRates as $exchangeRate)
                            <tr class="odd:bg-gray-900 even:bg-gray-600-">
                                <td class="px-6 py-4">{{ $exchangeRate->currency_from }}</td>
                                <td class="px-6 py-4">{{ $exchangeRate->currency_to }}</td>
                                <td class="px-6 py-4">{{ $exchangeRate->rate }}</td>
                                <td class="px-6 py-4">{{ $exchangeRate->datetime }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
