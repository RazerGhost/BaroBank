<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Currency Exchange-Rates') }}
         </h2>
     </x-slot>

     <div class="py-12">
         <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
             <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                 <div class="p-6 text-gray-900 dark:text-gray-100">
                     <h1 class="text-3xl font-bold">Exchange-Rates</h1>
                     <div class="container mx-auto p-4 overflow-x-auto">
                         <div class="mb-4 flex">
                             <div class="mr-4">
                                 <label for="currencyFrom" class="mr-2">Currency From:</label>
                                 <input type="text" id="currencyFrom" name="currencyFrom"
                                        class="px-2 py-1 border border-gray-300 rounded text-black">
                             </div>

                             <div class="mr-4">
                                 <label for="currencyTo" class="mr-2">Currency To:</label>
                                 <input type="text" id="currencyTo" name="currencyTo"
                                        class="px-2 py-1 border border-gray-300 rounded text-black">
                             </div>

                             <div class="mr-4">
                                 <label for="rate" class="mr-2">Rate:</label>
                                 <input type="text" id="rate" name="rate"
                                        class="px-2 py-1 border border-gray-300 rounded text-black">
                             </div>

                             <div class="mr-4">
                                 <label for="date" class="mr-2">Date:</label>
                                 <input type="text" id="date" name="date"
                                        class="px-2 py-1 border border-gray-300 rounded text-black">
                             </div>

                             <div>
                                 <button type="button" id="filterButton" class="px-4 py-2 bg-blue-500 text-white rounded">Apply Filter
                                 </button>
                             </div>
                         </div>

                         <div class="flex items-center">
                             <label for="perPage" class="mr-2">Rows per page:</label>
                             <select id="perPage" name="perPage" class="px-6 py-2 border border-gray-300 rounded text-black">
                                 <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }} class="text-black">10</option>
                                <option value="25" {{ request('perPage') == 25 ? 'selected' : '' }} class="text-black">25</option>
                                <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }} class="text-black">50</option>
                                <option value="100" {{ request('perPage') == 100 ? 'selected' : '' }} class="text-black">100</option>
                                <option value="200" {{ request('perPage') == 250 ? 'selected' : '' }} class="text-black">250</option>
                                <option value="500" {{ request('perPage') == 500 ? 'selected' : '' }} class="text-black">500</option>
                                <option value="1500" {{ request('perPage') == 1500 ? 'selected' : '' }} class="text-black">All</option>
                                <!-- Add more options as per your requirement -->
                            </select>
                            <button type="button" id="applyPerPageButton" class="px-4 py-2 ml-2 bg-blue-500 text-white rounded">Apply</button>
                        </div>
                    </div>

                    <table id="exchangeRatesTable" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
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
                                <td class="px-6 py-4 currency-from">{{ $exchangeRate->currency_from }}</td>
                                <td class="px-6 py-4 currency-to">{{ $exchangeRate->currency_to }}</td>
                                <td class="px-6 py-4 rate">{{ $exchangeRate->rate }}</td>
                                <td class="px-6 py-4 date">{{ $exchangeRate->datetime }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $exchangeRates->appends(request()->query())->links('pagination::tailwind') }}
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#filterButton').click(function () {
                applyFilters();
            });

            $('#resetButton').click(function () {
                resetFilters();
            });

            $('#applyPerPageButton').click(function () {
                updateRowsPerPage();
            });

            function applyFilters() {
                var currencyFrom = $('#currencyFrom').val().toUpperCase();
                var currencyTo = $('#currencyTo').val().toUpperCase();
                var rate = $('#rate').val().toLowerCase();
                var date = $('#date').val().toLowerCase();

                $('#exchangeRatesTable tbody tr').each(function () {
                    var row = $(this);
                    var rowCurrencyFrom = row.find('.currency-from').text().toUpperCase();
                    var rowCurrencyTo = row.find('.currency-to').text().toUpperCase();
                    var rowRate = row.find('.rate').text().toLowerCase();
                    var rowDate = row.find('.date').text().toLowerCase();

                    var showRow = true;

                    if (currencyFrom !== '' && !rowCurrencyFrom.includes(currencyFrom)) {
                        showRow = false;
                    }

                    if (currencyTo !== '' && !rowCurrencyTo.includes(currencyTo)) {
                        showRow = false;
                    }

                    if (rate !== '' && !rowRate.includes(rate)) {
                        showRow = false;
                    }

                    if (date !== '' && !rowDate.includes(date)) {
                        showRow = false;
                    }

                    if (showRow) {
                        row.show();
                    } else {
                        row.hide();
                    }
                });
            }

            function resetFilters() {
                $('#currencyFrom').val('');
                $('#currencyTo').val('');
                $('#rate').val('');
                $('#date').val('');

                $('#exchangeRatesTable tbody tr').show();
            }

            function updateRowsPerPage() {
                var perPage = $('#perPage').val();
                var url = '{{ route("exchangerates.index") }}?perPage=' + perPage;
                window.location.href = url;
            }
        });
    </script>

</x-app-layout>
