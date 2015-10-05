<?php

namespace App\Http\Controllers;

use App\Fund;
use App\ProvisionType;

class FundProvisionTypesController extends Controller
{

    public function __construct()
    {
        $this->middleware('oauth', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Fund $fund
     * @return \Illuminate\Http\Response
     *
     */
    public function index(Fund $fund)
    {
        return response()->json(['data' => $fund->provision_types], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Fund $fund
     * @param ProvisionType $provision_type
     * @return \Illuminate\Http\Response
     * @internal param $fund_id
     * @internal param $provision_type_id
     *
     */
    public function show(Fund $fund, ProvisionType $provision_type)
    {
        $provision_type = $fund->provision_types->find($provision_type->id);

        if (!$provision_type) {
            return response()->json(['message' => 'This provision type is not associated with this fund.', 'code' => 404], 404);
        }

        return response()->json(['data' => $provision_type], 200);
    }
}
