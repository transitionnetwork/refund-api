<?php

namespace App\Http\Controllers;

use App\Country;
use App\Fund;

class CountryFundsController extends Controller
{

    public function __construct()
    {
        $this->middleware('oauth', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Country $country
     * @return \Illuminate\Http\Response
     */
    public function index(Country $country)
    {
        return response()->json(['data' => $country->funds], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Country $country
     * @param Fund $fund
     * @return \Illuminate\Http\Response
     */
    public function show(Country $country, Fund $fund)
    {
        $fund = $country->funds->find($fund->id);

        if (!$fund) {
            return response()->json(['message' => 'The fund is not associated with this country.', 'code' => 404], 404);
        }

        return response()->json(['data' => $fund], 200);
    }
}
