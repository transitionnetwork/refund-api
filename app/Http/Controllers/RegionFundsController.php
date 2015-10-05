<?php

namespace App\Http\Controllers;

use App\Fund;
use App\Region;

class RegionFundsController extends Controller
{
    public function __construct()
    {
        $this->middleware('oauth', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Region $region
     * @return \Illuminate\Http\Response
     *
     */
    public function index(Region $region)
    {
        return response()->json(['data' => $region->funds], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Region $region
     * @param Fund $fund
     * @return \Illuminate\Http\Response
     *
     */
    public function show(Region $region, Fund $fund)
    {
        $fund = $region->funds->find($fund->id);

        if (!$fund) {
            return response()->json(['message' => 'The fund could not be found within this region.', 'code' => 404], 404);
        }

        return response()->json(['data' => $fund], 200);
    }
}
