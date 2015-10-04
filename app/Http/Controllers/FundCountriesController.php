<?php

namespace App\Http\Controllers;

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
     * @param $fund_id
     *
     * @return \Illuminate\Http\Response
     */
    public function index($fund_id)
    {
        $fund = Fund::find($fund_id);

        if (!$fund) {
            return response()->json(['message' => 'The fund could not be found.', 'code' => 404], 404);
        }

        return response()->json(['data' => $fund->countries], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param $fund_id
     * @param $country_id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($fund_id, $country_id)
    {
        $fund = Fund::find($fund_id);

        if (!$fund) {
            return response()->json(['message' => 'The fund could not be found.', 'code' => 404], 404);
        }

        $country = $fund->countries->find($country_id);

        if (!$country) {
            return response()->json(['message' => 'This country is not associated with this fund.', 'code' => 404], 404);
        }

        return response()->json(['data' => $country], 200);
    }
}
