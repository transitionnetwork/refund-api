<?php

namespace App\Http\Controllers;

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
     * @param $organisation_type_id
     *
     * @return \Illuminate\Http\Response
     */
    public function index($organisation_type_id)
    {
        $organisation_type = OrganisationType::find($organisation_type_id);

        if (!$organisation_type) {
            return response()->json(['message' => 'The organisation type could not be found.', 'code' => 404], 404);
        }

        return response()->json(['data' => $organisation_type->funds], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param $organisation_type_id
     * @param $fund_id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($organisation_type_id, $fund_id)
    {
        $organisation_type = OrganisationType::find($organisation_type_id);

        if (!$organisation_type) {
            return response()->json(['message' => 'The organisation type could not be found.', 'code' => 404], 404);
        }

        $fund = $organisation_type->funds->find($fund_id);

        if (!$fund) {
            return response()->json(['message' => 'The fund is not associated with this organisation type.', 'code' => 404], 404);
        }

        return response()->json(['data' => $fund], 200);
    }
}
