<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <form action="{{ route('dashboard') }}" method="GET" class="p-6">
                    <div class="flex flex-auto flex-row justify-center text-center">
                        <div>
                            <label for="currencies1" class="mr-2 text-white font-medium">Currencies From:</label>
                            <select name="currencies1[]" id="currencies1" multiple class="border-gray-300 rounded-md">
                                <!-- Generate options for currency selection -->
                                @foreach ($selectedCurrencies1 as $currency => $data)
                                    <option class="text-black" value="{{ $currency }}" {{ in_array($currency, request('currencies1', [])) ? 'selected' : '' }}>
                                        {{ $currency }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="currencies2" class="mr-2 text-white font-medium">Currencies To:</label>
                            <select name="currencies2[]" id="currencies2" multiple class="border-gray-300 rounded-md">
                                <!-- Generate options for currency selection -->
                                @foreach ($selectedCurrencies2 as $currency => $data)
                                    <option value="{{ $currency }}" {{ in_array($currency, request('currencies2', [])) ? 'selected' : '' }}>
                                        {{ $currency }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="currencies3" class="mr-2 text-white font-medium">Second Currencies From:</label>
                            <select name="currencies3[]" id="currencies3" multiple class="border-gray-300 rounded-md">
                                <!-- Generate options for currency selection -->
                                @foreach ($selectedCurrencies3 as $currency => $data)
                                    <option value="{{ $currency }}" {{ in_array($currency, request('currencies3', [])) ? 'selected' : '' }}>
                                        {{ $currency }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="currencies4" class="mr-2 text-white font-medium">Second Currencies To:</label>
                            <select name="currencies4[]" id="currencies4" multiple class="border-gray-300 rounded-md">
                                <!-- Generate options for currency selection -->
                                @foreach ($selectedCurrencies4 as $currency => $data)
                                    <option value="{{ $currency }}" {{ in_array($currency, request('currencies4', [])) ? 'selected' : '' }}>
                                        {{ $currency }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Apply
                    </button>
                </form>
            </div>



            <div class="grid grid-cols-2 gap-8 mt-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <canvas id="myChart1" height="400"></canvas>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                        <script type="text/javascript">
                            var currencyData1 = <?php echo json_encode($selectedCurrencies1); ?>;
                            var currencyData2 = <?php echo json_encode($selectedCurrencies2); ?>;
                            var datasets1 = [];

                            for (var currency in currencyData1) {
                                var data = currencyData1[currency];
                                var rates = data.map(function (item) {
                                    return item.rate;
                                });
                                var labels = data.map(function (item) {
                                    return item.datetime;
                                });

                                datasets1.push({
                                    label: currency,
                                    backgroundColor: 'rgb(255, 99, 132)',
                                    borderColor: 'rgb(255, 99, 132)',
                                    data: rates
                                });
                            }

                            for (var currency in currencyData2) {
                                var data = currencyData2[currency];
                                var rates = data.map(function (item) {
                                    return item.rate;
                                });
                                var labels = data.map(function (item) {
                                    return item.datetime;
                                });

                                datasets1.push({
                                    label: currency,
                                    backgroundColor: 'rgb(54, 99, 132)',
                                    borderColor: 'rgb(54, 99, 132)',
                                    data: rates
                                });
                            }

                            var config1 = {
                                type: 'line',
                                data: {
                                    labels: labels,
                                    datasets: datasets1
                                },
                                options: {
                                    responsive: true,
                                    interaction: {
                                        mode: 'index',
                                        intersect: true
                                    },
                                    scales: {
                                        x: {
                                            display: true,
                                            title: {
                                                display: true,
                                                text: 'Dates'
                                            }
                                        },
                                        y: {
                                            display: true,
                                            title: {
                                                display: true,
                                                text: 'Exchange Rate'
                                            }
                                        }
                                    },
                                    plugins: {
                                        title: {
                                            display: true,
                                            text: 'Exchange Rate Trend by Currency'
                                        },
                                        tooltip: {
                                            mode: 'index',
                                            intersect: false
                                        },
                                        legend: {
                                            position: 'bottom'
                                        }
                                    }
                                }
                            };

                            var myChart1 = new Chart(
                                document.getElementById('myChart1'),
                                config1
                            );
                        </script>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <canvas id="myChart2" height="400"></canvas>
                        <script type="text/javascript">
                            var currencyData3 = <?php echo json_encode($selectedCurrencies3); ?>;
                            var currencyData4 = <?php echo json_encode($selectedCurrencies4); ?>;
                            var datasets2 = [];

                            for (var currency in currencyData3) {
                                var data = currencyData3[currency];
                                var rates = data.map(function (item) {
                                    return item.rate;
                                });
                                var labels = data.map(function (item) {
                                    return item.datetime;
                                });

                                datasets2.push({
                                    label: currency,
                                    backgroundColor: 'rgb(23, 99, 132)',
                                    borderColor: 'rgb(23, 99, 132)',
                                    data: rates
                                });
                            }

                            for (var currency in currencyData4) {
                                var data = currencyData4[currency];
                                var rates = data.map(function (item) {
                                    return item.rate;
                                });
                                var labels = data.map(function (item) {
                                    return item.datetime;
                                });

                                datasets2.push({
                                    label: currency,
                                    backgroundColor: 'rgb(100, 99, 132)',
                                    borderColor: 'rgb(100, 99, 132)',
                                    data: rates
                                });
                            }

                            var config2 = {
                                type: 'line',
                                data: {
                                    labels: labels,
                                    datasets: datasets2
                                },
                                options: {
                                    responsive: true,
                                    interaction: {
                                        mode: 'index',
                                        intersect: true
                                    },
                                    scales: {
                                        x: {
                                            display: true,
                                            title: {
                                                display: true,
                                                text: 'Dates'
                                            }
                                        },
                                        y: {
                                            display: true,
                                            title: {
                                                display: true,
                                                text: 'Exchange Rate'
                                            }
                                        }
                                    },
                                    plugins: {
                                        title: {
                                            display: true,
                                            text: 'Exchange Rate Trend by Currency'
                                        },
                                        tooltip: {
                                            mode: 'index',
                                            intersect: false
                                        },
                                        legend: {
                                            position: 'bottom'
                                        }
                                    }
                                }
                            };

                            var myChart2 = new Chart(
                                document.getElementById('myChart2'),
                                config2
                            );
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
