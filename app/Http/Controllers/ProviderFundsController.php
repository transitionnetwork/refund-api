<?php

namespace App\Http\Controllers;

use App\Fund;
use App\Provider;

class ProviderFundsController extends Controller
{
    public function __construct()
    {
        $this->middleware('oauth', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Provider $provider
     * @return \Illuminate\Http\Response
     *
     */
    public function index(Provider $provider)
    {
        return response()->json(['data' => $provider->funds], 200);
    }

    public function show(Provider $provider, Fund $fund)
    {
        $fund = $provider->funds->find($fund->id);

        if (!$fund) {
            return response()->json(['message' => 'This fund is not associated with this provider.', 'code' => 404], 404);
        }

        return response()->json(['data' => $fund], 200);
    }
}
