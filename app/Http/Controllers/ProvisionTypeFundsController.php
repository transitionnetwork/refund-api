<?php

namespace App\Http\Controllers;

use App\Fund;
use App\ProvisionType;

class ProvisionTypeFundsController extends Controller
{
    public function __construct()
    {
        $this->middleware('oauth', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param ProvisionType $provision_type
     * @return \Illuminate\Http\Response
     */
    public function index(ProvisionType $provision_type)
    {
        return response()->json(['data' => $provision_type->funds], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param ProvisionType $provision_type
     * @param Fund $fund
     * @return \Illuminate\Http\Response
     *
     */
    public function show(ProvisionType $provision_type, Fund $fund)
    {
        $fund = $provision_type->funds->find($fund->id);

        if (!$fund) {
            return response()->json(['message' => 'The fund is not associated with this provision type.', 'code' => 404], 404);
        }

        return response()->json(['data' => $fund], 200);
    }
}
