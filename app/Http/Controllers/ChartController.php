<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('exchange_rates');

        // Apply filters for currency from and currency to
        $currenciesFrom = $request->input('currenciesFrom');
        $currenciesTo = $request->input('currenciesTo');

        if (is_array($currenciesFrom) && count($currenciesFrom) > 0) {
            $query->whereIn('currency_from', $currenciesFrom);
        }

        if (is_array($currenciesTo) && count($currenciesTo) > 0) {
            $query->whereIn('currency_to', $currenciesTo);
        }

        $exchangeChart = $query->orderBy('rate')->get();

        $currencyRateFrom = [];
        $currencyRateTo = [];

        foreach ($exchangeChart as $row) {
            $currencyRateFrom[$row->currency_from][] = [
                'datetime' => $row->datetime,
                'rate' => $row->rate,
            ];

            $currencyRateTo[$row->currency_to][] = [
                'datetime' => $row->datetime,
                'rate' => $row->rate,
            ];
        }

        return view('dashboard', compact('currencyRateFrom', 'currencyRateTo'));
    }
}
