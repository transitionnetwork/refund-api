<?php

namespace App\Http\Controllers;

use App\Fund;
use App\Region;

class FundRegionsController extends Controller
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
        return response()->json(['data' => $fund->regions], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Fund   $fund
     * @param Region $region
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Fund $fund, Region $region)
    {
        $region = $fund->regions->find($region->id);

        if (!$region) {
            return response()->json(['message' => 'This region is not associated with this fund.', 'code' => 404], 404);
        }

        return response()->json(['data' => $region], 200);
    }
}
