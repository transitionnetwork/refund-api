<?php

namespace App\Http\Controllers;

use App\Country;
use App\Fund;

class FundCountriesController extends Controller
{

    public function __construct()
    {
        $this->middleware('oauth', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Fund $fund
     * @return \Illuminate\Http\Response
     *
     */
    public function index(Fund $fund)
    {
        return response()->json(['data' => $fund->countries], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Fund $fund
     * @param Country $country
     * @return \Illuminate\Http\Response
     */
    public function show(Fund $fund, Country $country)
    {
        $country = $fund->countries->find($country->id);

        if ( ! $country) {
            return response()->json(['message' => 'This country is not associated with this fund.', 'code' => 404], 404);
        }

        return response()->json(['data' => $country], 200);
    }
}
