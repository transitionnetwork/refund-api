<?php

namespace App\Http\Controllers;

use App\Fund;

class FundLocationsController extends Controller
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

        return response()->json(['data' => $fund->locations], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param $fund_id
     * @param $location_id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($fund_id, $location_id)
    {
        $fund = Fund::find($fund_id);

        if (!$fund) {
            return response()->json(['message' => 'The fund could not be found.', 'code' => 404], 404);
        }

        $location = $fund->locations->find($location_id);

        if (!$location) {
            return response()->json(['message' => 'This location is not associated with this fund.', 'code' => 404], 404);
        }

        return response()->json(['data' => $location], 200);
    }
}
