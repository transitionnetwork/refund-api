<?php

namespace App\Http\Controllers;

use App\Provider;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProviderFundsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param $provider_id
     * @return \Illuminate\Http\Response
     */
    public function index($provider_id)
    {
        $provider = Provider::find($provider_id);

        if (!$provider) {
            return response()->json(['message' => 'The provider could not be found.', 'code' => 404], 404);
        }

        return response()->json(['data' => $provider->funds], 200);
    }

    public function show($provider_id, $fund_id)
    {
        $provider = Provider::find($provider_id);

        if (!$provider) {
            return response()->json(['message' => 'The provider could not be found.', 'code' => 404], 404);
        }

        $fund = $provider->funds->find($fund_id);

        if (!$fund) {
            return response()->json(['message' => 'This fund is not associated with this provider.', 'code' => 404], 404);
        }

        return response()->json(['data' => $fund], 200);
    }
}
