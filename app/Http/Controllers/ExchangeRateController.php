<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExchangeRate;

class ExchangeRateController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 25);
        $exchangeRates = ExchangeRate::paginate($perPage);
        return view('exchangerates.index', compact('exchangeRates'));
    }
}
