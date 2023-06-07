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
                    <table>
                        <thead>
                        <tr>
                            <th>Currency From</th>
                            <th>Currency To</th>
                            <th>Rate</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($exchangeRates as $exchangeRate)
                            <tr>
                                <td>{{ $exchangeRate->currency_from }}</td>
                                <td>{{ $exchangeRate->currency_to }}</td>
                                <td>{{ $exchangeRate->rate }}</td>
                                <td>{{ $exchangeRate->datetime }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
