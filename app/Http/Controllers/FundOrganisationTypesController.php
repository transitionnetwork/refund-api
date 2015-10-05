<?php

namespace App\Http\Controllers;

use App\Fund;
use App\OrganisationType;

class FundOrganisationTypesController extends Controller
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
        return response()->json(['data' => $fund->organisation_types], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Fund             $fund
     * @param OrganisationType $organisation_type
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Fund $fund, OrganisationType $organisation_type)
    {
        $organisation_type = $fund->organisation_types->find($organisation_type->id);

        if (!$organisation_type) {
            return response()->json(['message' => 'This organisation type is not associated with this fund.', 'code' => 404], 404);
        }

        return response()->json(['data' => $organisation_type], 200);
    }
}
