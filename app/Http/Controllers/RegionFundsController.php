<?php

namespace App\Http\Controllers;

use App\Region;
use Illuminate\Http\Request;
use App\Http\Requests;

class RegionFundsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param $region_id
     * @return \Illuminate\Http\Response
     */
    public function index($region_id)
    {
        $region = Region::find($region_id);

        if (!$region) {
            return response()->json(['message' => 'The region could not be found.', 'code' => 404], 404);
        }

        return response()->json(['data' => $region->funds], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param $region_id
     * @param $fund_id
     * @return \Illuminate\Http\Response
     */
    public function show($region_id, $fund_id)
    {
        $region = Region::find($region_id);

        if (!$region) {
            return response()->json(['message' => 'The region could not be found.', 'code' => 404], 404);
        }

        $fund = $region->funds->find($fund_id);

        if (!$fund) {
            return response()->json(['message' => 'The fund could not be found within this region.', 'code' => 404], 404);
        }

        return response()->json(['data' => $fund], 200);
    }
}
