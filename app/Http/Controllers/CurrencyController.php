<?php

namespace App\Http\Controllers;

use App\Currency;
use App\Http\Resources\CurrencyResource;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CurrencyResource::collection(
            Currency::fromCache()
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function show(Currency $currency)
    {
        return new CurrencyResource(
            $currency
        );
    }
}
