<?php

namespace App\Http\Controllers;

use App\Fund;

class FundOrganisationTypesController extends Controller
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

        return response()->json(['data' => $fund->organisation_types], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param $fund_id
     * @param $organisation_type_id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($fund_id, $organisation_type_id)
    {
        $fund = Fund::find($fund_id);

        if (!$fund) {
            return response()->json(['message' => 'The fund could not be found.', 'code' => 404], 404);
        }

        $organisation_type = $fund->organisation_types->find($organisation_type_id);

        if (!$organisation_type) {
            return response()->json(['message' => 'This organisation type is not associated with this fund.', 'code' => 404], 404);
        }

        return response()->json(['data' => $organisation_type], 200);
    }
}
