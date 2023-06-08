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
                            <div>
                                <label for="currenciesFrom">Currency From:</label>
                                <input type="text" name="currenciesFrom[]" id="currenciesFrom"
                                       value="{{ implode(',', request('currenciesFrom', [])) }}"
                                       class="border-gray-300 rounded-md px-2 py-1 text-black">
                            </div>

                            <div class="ml-4">
                                <label for="currenciesTo">Currency To:</label>
                                <input type="text" name="currenciesTo[]" id="currenciesTo"
                                       value="{{ implode(',', request('currenciesTo', [])) }}"
                                       class="border-gray-300 rounded-md px-2 py-1 text-black">
                            </div>

                            <button type="submit"
                                    class="ml-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Apply
                            </button>
                        </div>
                        <div id="warning"></div>
                    </form>

                    <script>
                        var currenciesFromInput = document.getElementById('currenciesFrom');
                        var currenciesToInput = document.getElementById('currenciesTo');
                        var warningContainer = document.getElementById('warning');

                        currenciesFromInput.addEventListener('input', validateCurrencies);
                        currenciesToInput.addEventListener('input', validateCurrencies);

                        function validateCurrencies() {
                            var currenciesFrom = currenciesFromInput.value.split(',');
                            var currenciesTo = currenciesToInput.value.split(',');

                            var invalidCurrencies = currenciesFrom.concat(currenciesTo).filter(function (currency) {
                                return currency.trim() !== '' && !currencyExists(currency);
                            });

                            if (invalidCurrencies.length > 0) {
                                warningContainer.textContent = 'Invalid currencies: ' + invalidCurrencies.join(', ');
                                warningContainer.style.color = 'red';
                            } else {
                                warningContainer.textContent = '';
                            }
                        }

                        function currencyExists(currency) {
                            var currencyRateFrom = <?php echo json_encode(array_keys($currencyRateFrom)); ?>;
                            var currencyRateTo = <?php echo json_encode(array_keys($currencyRateTo)); ?>;
                            return currencyRateFrom.includes(currency) || currencyRateTo.includes(currency);
                        }
                    </script>

                    <canvas id="myChart" height="400"></canvas>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script type="text/javascript">
                        var currencyRateFrom = <?php echo json_encode($currencyRateFrom); ?>;
                        var currencyRateTo = <?php echo json_encode($currencyRateTo); ?>;
                        var datasetsFrom = [];
                        var datasetsTo = [];

                        for (var currency in currencyRateFrom) {
                            var data = currencyRateFrom[currency];
                            var rates = data.map(function (item) {
                                return item.rate;
                            });
                            var labels = data.map(function (item) {
                                return item.datetime;
                            });

                            datasetsFrom.push({
                                label: currency,
                                backgroundColor: 'rgba(255, 99, 132, 50)',
                                borderColor: 'rgba(255, 99, 132, 50)',
                                data: rates
                            });
                        }

                        for (var currency in currencyRateTo) {
                            var data = currencyRateTo[currency];
                            var rates = data.map(function (item) {
                                return item.rate;
                            });
                            var labels = data.map(function (item) {
                                return item.datetime;
                            });

                            datasetsTo.push({
                                label: currency,
                                backgroundColor: 'rgba(54, 162, 235, 50)',
                                borderColor: 'rgba(54, 162, 235, 50)',
                                data: rates
                            });
                        }

                        var config = {
                            type: 'line',
                            data: {
                                labels: labels,
                                datasets: [
                                    ...datasetsFrom,
                                    ...datasetsTo
                                ]
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
