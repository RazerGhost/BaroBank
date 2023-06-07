<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExchangeRate;

class ExchangeRateController extends Controller
{
    public function index()
    {
        $exchangeRates = ExchangeRate::all();
        return view('exchangerates.table', compact('exchangeRates'));
    }
}
