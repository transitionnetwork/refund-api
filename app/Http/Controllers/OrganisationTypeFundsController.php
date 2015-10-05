<?php

namespace App\Http\Controllers;

use App\Fund;
use App\OrganisationType;

class OrganisationTypeFundsController extends Controller
{
    public function __construct()
    {
        $this->middleware('oauth', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param OrganisationType $organisation_type
     *
     * @return \Illuminate\Http\Response
     */
    public function index(OrganisationType $organisation_type)
    {
        return response()->json(['data' => $organisation_type->funds], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param OrganisationType $organisation_type
     * @param Fund             $fund
     *
     * @return \Illuminate\Http\Response
     */
    public function show(OrganisationType $organisation_type, Fund $fund)
    {
        $fund = $organisation_type->funds->find($fund->id);

        if (!$fund) {
            return response()->json(['message' => 'The fund is not associated with this organisation type.', 'code' => 404], 404);
        }

        return response()->json(['data' => $fund], 200);
    }
}
