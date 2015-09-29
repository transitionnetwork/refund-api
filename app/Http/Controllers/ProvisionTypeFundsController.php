<?php

namespace App\Http\Controllers;

use App\ProvisionType;
use Illuminate\Http\Request;
use App\Http\Requests;

class ProvisionTypeFundsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param $provision_type_id
     * @return \Illuminate\Http\Response
     */
    public function index($provision_type_id)
    {
        $provision_type = ProvisionType::find($provision_type_id);

        if (!$provision_type) {
            return response()->json(['message' => 'The provision type could not be found.', 'code' => 404], 404);
        }

        return response()->json(['data' => $provision_type->funds], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param $provision_type_id
     * @param $fund_id
     * @return \Illuminate\Http\Response
     */
    public function show($provision_type_id, $fund_id)
    {
        $provision_type = ProvisionType::find($provision_type_id);

        if (!$provision_type) {
            return response()->json(['message' => 'The provision type could not be found.', 'code' => 404], 404);
        }

        $fund = $provision_type->funds->find($fund_id);

        if (!$fund) {
            return response()->json(['message' => 'The fund is not associated with this provision type.', 'code' => 404], 404);
        }

        return response()->json(['data' => $fund], 200);
    }
}
