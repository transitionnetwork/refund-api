<?php

namespace App\Http\Controllers;

use App\Fund;

class FundProvisionTypesController extends Controller
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

        return response()->json(['data' => $fund->provision_types], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param $fund_id
     * @param $provision_type_id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($fund_id, $provision_type_id)
    {
        $fund = Fund::find($fund_id);

        if (!$fund) {
            return response()->json(['message' => 'The fund could not be found.', 'code' => 404], 404);
        }

        $provision_type = $fund->provision_types->find($provision_type_id);

        if (!$provision_type) {
            return response()->json(['message' => 'This provision type is not associated with this fund.', 'code' => 404], 404);
        }

        return response()->json(['data' => $provision_type], 200);
    }
}
