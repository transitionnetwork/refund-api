<?php

namespace App\Http\Controllers;

use App\Fund;
use App\Http\Requests\CreateFundRequest;
use Illuminate\Http\Request;

class FundController extends Controller
{
    public function __construct()
    {
        $this->middleware('oauth', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $funds = Fund::all();

        if ($request->has('format') && $request->get('format') == 'frontend')
        {
            return $this->frontendJSONTransformer($funds);
        }

        return response()->json(['data' => $funds], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateFundRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateFundRequest $request)
    {
        $values = $request->only([
            'provider_id',
            'name',
            'website',
            'investment_term',
            'loans_rate',
            'min_size',
            'max_size',
            'focus',
            'status',
        ]);

        Fund::create($values);

        return response()->json(['message' => 'Fund successfully created.', 'code' => 201], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Fund $fund
     * @return \Illuminate\Http\Response
     *
     */
    public function show(Fund $fund)
    {
        return response()->json(['data' => $fund], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function frontendJSONTransformer($funds)
    {
        $response = [];

        foreach ($funds as $fund)
        {
            if ( ! is_null($fund->provider) && isset($fund->provider->name))
            {
                $data = [];

                $data[] = ['name' => 'provider', 'value' => $fund->provider->name];
                $data[] = ['name' => 'fund', 'value' => $fund->name];
                $data[] = ['name' => 'weblink', 'value' => $fund->website];
                $data[] = ['name' => 'description', 'value' => $fund->focus];
                $data[] = ['name' => 'grant', 'value' => $fund->hasProvisionType('Grant')];
                $data[] = ['name' => 'debt', 'value' => $fund->hasProvisionType('Loans')];
                $data[] = ['name' => 'equity', 'value' => $fund->hasProvisionType('Equity')];
                $data[] = ['name' => 'support', 'value' => $fund->hasProvisionType('Support')];
                $data[] = ['name' => 'platform', 'value' => $fund->hasProvisionType('Platform')];
                $data[] = ['name' => 'legislation', 'value' => $fund->hasProvisionType('Legislation')];
                $data[] = ['name' => 'date', 'value' => $fund->created_at->format('Y/m/d')];

                $regions = [];

                foreach ($fund->regions as $region)
                {
                    $regions[] = $region->name;
                }

                $data[] = ['name' => 'regions', 'value' => $regions];

                $locations = [];

                foreach ($fund->locations as $location)
                {
                    $locations[] = $location->name;
                }
                $data[] = ['name' => 'locations', 'value' => $locations];

                // Quickview
                $data[] = ['name' => 'quickview', 'data' => [

                ]];

                $response[] = $data;
            }
        }

        return response()->json(['data' => $response], 200);
    }
}
