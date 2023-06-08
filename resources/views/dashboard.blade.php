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
                    <h1 class="text-3xl font-bold">Welcome to your dashboard</h1>
                    <form action="{{ route('dashboard') }}" method="GET">
                        <div class="flex items-center mt-4">
                            <label for="currencies_from" class="mr-2">Currencies From:</label>
                            <select name="currencies[]" id="currencies_from" multiple class="border-gray-300 rounded-md">
                                <!-- Generate options for currency selection -->
                                @foreach ($currencyData as $currency => $data)
                                    <option value="{{ $currency }}" {{ in_array($currency, request('currency_from', [])) ? 'selected' : '' }}>
                                        {{ $currency }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="ml-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Apply
                            </button>
                        </div>
                    </form>

                    <canvas id="myChart" height="400"></canvas>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script type="text/javascript">
                        var currencyData = <?php echo json_encode($currencyData); ?>;
                        var datasets = [];

                        for (var currency in currencyData) {
                            var data = currencyData[currency];
                            var rates = data.map(function(item) { return item.rate; });
                            var labels = data.map(function(item) { return item.datetime; });

                            datasets.push({
                                label: currency,
                                backgroundColor: 'rgb(255, 99, 132)',
                                borderColor: 'rgb(255, 99, 132)',
                                data: rates
                            });
                        }

                        var config = {
                            type: 'line',
                            data: {
                                labels: labels,
                                datasets: datasets
                            },
                            options: {
                                responsive: true,
                                interaction: {
                                    mode: 'index',
                                    intersect: false
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

                        var myChart = new Chart(
                            document.getElementById('myChart'),
                            config
                        );
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
