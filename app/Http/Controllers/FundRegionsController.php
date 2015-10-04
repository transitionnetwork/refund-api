<?php

namespace App\Http\Controllers;

use App\Fund;

class FundRegionsController extends Controller
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

        return response()->json(['data' => $fund->regions], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param $fund_id
     * @param $region_id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($fund_id, $region_id)
    {
        $fund = Fund::find($fund_id);

        if (!$fund) {
            return response()->json(['message' => 'The fund could not be found.', 'code' => 404], 404);
        }

        $region = $fund->regions->find($region_id);

        if (!$region) {
            return response()->json(['message' => 'This region is not associated with this fund.', 'code' => 404], 404);
        }

        return response()->json(['data' => $region], 200);
    }
}
