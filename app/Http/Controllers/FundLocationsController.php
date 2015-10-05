<?php

namespace App\Http\Controllers;

use App\Fund;
use App\Location;

class FundLocationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('oauth', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Fund $fund
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Fund $fund)
    {
        return response()->json(['data' => $fund->locations], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Fund     $fund
     * @param Location $location
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Fund $fund, Location $location)
    {
        $location = $fund->locations->find($location->id);

        if (!$location) {
            return response()->json(['message' => 'This location is not associated with this fund.', 'code' => 404], 404);
        }

        return response()->json(['data' => $location], 200);
    }
}
