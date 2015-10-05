<?php

namespace App\Http\Controllers;

use App\Fund;
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
     * @param Location $location
     * @return \Illuminate\Http\Response
     *
     */
    public function index(Location $location)
    {
        return response()->json(['data' => $location->funds], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Location $location
     * @param Fund $fund
     * @return \Illuminate\Http\Response
     *
     */
    public function show(Location $location, Fund $fund)
    {
        $fund = $location->funds->find($fund->id);

        if (!$fund) {
            return response()->json(['message' => 'The fund is not associated with this location.', 'code' => 404], 404);
        }

        return response()->json(['data' => $fund], 200);
    }
}
