<?php

namespace App\Http\Controllers;

use App\Fund;
use App\Http\Requests\CreateFundRequest;
use Cache;
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
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $funds = Cache::remember('funds', 15, function () {
            return Fund::leftJoin('providers', function ($join) {
                $join->on('funds.provider_id', '=', 'providers.id');
            })->orderBy('providers.name')->get(['funds.*']);
        });

        if ($request->has('format') && $request->get('format') == 'frontend') {
            return Cache::remember('funds-frontend', 15, function () use ($funds) {
                return $this->frontendJSONTransformer($funds);
            });
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
     *
     * @return \Illuminate\Http\Response
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

        foreach ($funds as $fund) {
            $data = [];

            $data['name'] = $fund->name;
            $data['provider'] = isset($fund->provider->name) ? $fund->provider->name : '';

            $countries = '';

            if (!is_null($fund->countries)) {
                $countries = implode(', ', $fund->countries->lists('name')->toArray());
            }

            $data['countries'] = $countries;

            $regions = '';

            if (!is_null($fund->regions)) {
                $regions = implode(', ', $fund->regions->lists('name')->toArray());
            }

            $data['regions'] = $regions;

            $locations = '';

            if (!is_null($fund->locations)) {
                $locations = implode(', ', $fund->locations->lists('name')->toArray());
            }

            $data['locations'] = $locations;
            $data['max'] = $fund->max_size;

            $data['date'] = $fund->created_at->format('d/m/y');
            $data['website'] = $fund->website;
            $data['edit'] = true;
            $data['description'] = $fund->focus;

            $data['profit'] = $fund->hasOrganisationType('For-profit');
            $data['non_profit'] = $fund->hasOrganisationType('Non-profit');

            if (!empty($fund->organisation_types->lists('name')->toArray())) {
                $supports = implode(', ', $fund->organisation_types->lists('name')->toArray());
            }
            else
            {
                $supports = 'Unknown';
            }

            $data['supports'] = $supports;

            $data['other'] = ( ! $data['profit'] && ! $data['non_profit']);

            $data['grant']       = $fund->hasProvisionType('Grant');
            $data['debt']        = $fund->hasProvisionType('Loans');
            $data['equity']      = $fund->hasProvisionType('Equity');
            $data['support']     = $fund->hasProvisionType('Support');
            $data['platform']    = $fund->hasProvisionType('Platform');
            $data['legislation'] = $fund->hasProvisionType('Legislation');

            if ($fund->min_size == 0)
            {
                $fund->min_size = "-";
            }

            if ($fund->max_size == 0)
            {
                $fund->max_size = "-";
            }

            // Grant
            if ($fund->hasProvisionType('Grant')) {
                $data['quickview'][] = [
                    'name' => 'grants',
                    'min'  => $fund->min_size,
                    'max'  => $fund->max_size,
                    'term' => null,
                    'rate' => null,
                ];
            }

            // Loans
            if ($fund->hasProvisionType('Loans')) {
                $data['quickview'][] = [
                    'name' => 'loans',
                    'min'  => $fund->min_size,
                    'max'  => $fund->max_size,
                    'term' => $fund->investment_term,
                    'rate' => $fund->loans_rate,
                ];
            }

            // Equity
            if ($fund->hasProvisionType('Equity')) {
                $data['quickview'][] = [
                    'name' => 'equity',
                    'min'  => $fund->min_size,
                    'max'  => $fund->max_size,
                    'term' => null,
                    'rate' => null,
                ];
            }

            // Support
            if ($fund->hasProvisionType('Support')) {
                $data['quickview'][] = [
                    'name' => 'support',
                    'min'  => null,
                    'max'  => null,
                    'term' => null,
                    'rate' => null,
                ];
            }

            // Platform
            if ($fund->hasProvisionType('Platform')) {
                $data['quickview'][] = [
                    'name' => 'platform',
                    'min'  => null,
                    'max'  => null,
                    'term' => null,
                    'rate' => null,
                ];
            }

            // Legislation
            if ($fund->hasProvisionType('Legislation')) {
                $data['quickview'][] = [
                    'name' => 'legislation',
                    'min'  => null,
                    'max'  => null,
                    'term' => null,
                    'rate' => null,
                ];
            }

            $response[] = $data;
        }

        return response()->json($response, 200);
    }
}
