<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function index(Request $request)
    {
        $selectedCurrenciesFrom = $request->input('currencies_from', []);
        $selectedCurrenciesTo = $request->input('currencies_to', []);

        $query = DB::table('exchange_rates');

        if (!empty($selectedCurrenciesFrom)) {
            $query->whereIn('currency_from', $selectedCurrenciesFrom);
        }

        if (!empty($selectedCurrenciesTo)) {
            $query->whereIn('currency_to', $selectedCurrenciesTo);
        }

        $exchangeChart = $query->orderBy('datetime')->get();

        $currencyData = [];
        foreach ($exchangeChart as $row) {
            $currencyPair = $row->currency_from . ' to ' . $row->currency_to;
            $currencyData[$currencyPair][] = [
                'datetime' => $row->datetime,
                'rate' => $row->rate,
            ];
        }

        return view('dashboard', compact('currencyData'));
    }
}

