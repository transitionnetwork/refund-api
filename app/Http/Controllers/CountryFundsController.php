<?php

namespace App\Http\Controllers;

use App\Country;
use Illuminate\Http\Request;
use App\Http\Requests;

class CountryFundsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param $country_id
     * @return \Illuminate\Http\Response
     */
    public function index($country_id)
    {
        $country = Country::find($country_id);

        if (!$country) {
            return response()->json(['message' => 'The country could not be found.', 'code' => 404], 404);
        }

        return response()->json(['data' => $country->funds], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param $country_id
     * @param $fund_id
     * @return \Illuminate\Http\Response
     */
    public function show($country_id, $fund_id)
    {
        $country = Country::find($country_id);

        if (!$country) {
            return response()->json(['message' => 'The country could not be found.', 'code' => 404], 404);
        }

        $fund = $country->funds->find($fund_id);

        if (!$fund) {
            return response()->json(['message' => 'The fund is not associated with this country.', 'code' => 404], 404);
        }

        return response()->json(['data' => $fund], 200);
    }
}
