<?php

namespace App\Http\Controllers;

use App\Location;

class LocationFundsController extends Controller
{
    public function __construct()
    {
        $this->middleware('oauth', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param $location_id
     *
     * @return \Illuminate\Http\Response
     */
    public function index($location_id)
    {
        $location = Location::find($location_id);

        if (!$location) {
            return response()->json(['message' => 'The location could not be found.', 'code' => 404], 404);
        }

        return response()->json(['data' => $location->funds], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param $location_id
     * @param $fund_id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($location_id, $fund_id)
    {
        $location = Location::find($location_id);

        if (!$location) {
            return response()->json(['message' => 'The location could not be found.', 'code' => 404], 404);
        }

        $fund = $location->funds->find($fund_id);

        if (!$fund) {
            return response()->json(['message' => 'The fund is not associated with this location.', 'code' => 404], 404);
        }

        return response()->json(['data' => $fund], 200);
    }
}
