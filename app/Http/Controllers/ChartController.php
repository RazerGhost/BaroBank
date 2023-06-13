<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function chart(Request $request)
    {
        // Retrieve the necessary input data
        $selectedCurrencies1 = $request->input('currencies1', []);
        $selectedCurrencies2 = $request->input('currencies2', []);

        $selectedCurrencies3 = $request->input('currencies3', []);
        $selectedCurrencies4 = $request->input('currencies4', []);

        // Build the query
        $query = DB::table('exchange_rates');

        // Apply the filters based on the input data
        if (!empty($selectedCurrencies1)) {
            $query->whereIn('currency_from', $selectedCurrencies1);
        }
        if (!empty($selectedCurrencies2)) {
            $query->whereIn('currency_to', $selectedCurrencies2);
        }

        if (!empty($selectedCurrencies3)) {
            $query->whereIn('currency_from', $selectedCurrencies3);
        }
        if (!empty($selectedCurrencies4)) {
            $query->whereIn('currency_to', $selectedCurrencies4);
        }

        // Retrieve the chart data
        $exchangeChart = $query->orderBy('datetime')->get();

        // Process the chart data and pass it to the view
        $selectedCurrencies1 = [];
        $selectedCurrencies2 = [];
        $selectedCurrencies3 = [];
        $selectedCurrencies4 = [];

        foreach ($exchangeChart as $row) {
            $selectedCurrencies1[$row->currency_from][] = [
                'datetime' => $row->datetime,
                'rate' => $row->rate,
            ];
            $selectedCurrencies2[$row->currency_to][] = [
                'datetime' => $row->datetime,
                'rate' => $row->rate,
            ];
        }

        foreach ($exchangeChart as $row) {
            $selectedCurrencies3[$row->currency_from][] = [
                'datetime' => $row->datetime,
                'rate' => $row->rate,
            ];
            $selectedCurrencies4[$row->currency_to][] = [
                'datetime' => $row->datetime,
                'rate' => $row->rate,
            ];
        }
        // Pass the chart data to the view
        return view('dashboard', compact('selectedCurrencies1', 'selectedCurrencies2', 'selectedCurrencies3', 'selectedCurrencies4'));
    }
}
