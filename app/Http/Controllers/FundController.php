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

                $data['name']        = $fund->name;
                $data['provider']    = $fund->provider->name;
                $data['country']     = ( ! empty($fund->countries->toArray())) ? $fund->countries->toArray()[0]['name'] : null;
                $data['state']       = ( ! empty($fund->locations->toArray())) ? $fund->locations->toArray()[0]['name'] : null;
                $data['date']        = $fund->created_at->format('Y/m/d');
                $data['website']     = $fund->website;
                $data['edit']        = true;
                $data['description'] = $fund->focus;

                $data['cluster'] = [
                    'grant'       => $fund->hasProvisionType('Grant'),
                    'debt'        => $fund->hasProvisionType('Loans'),
                    'equity'      => $fund->hasProvisionType('Equity'),
                    'support'     => $fund->hasProvisionType('Support'),
                    'platform'    => $fund->hasProvisionType('Platform'),
                    'legislation' => $fund->hasProvisionType('Legislation'),
                ];

                // Grant
                if ($fund->hasProvisionType('Grant'))
                {
                    $data['quickview'][] = [
                        'name' => 'grants',
                        'min'  => $fund->min_size,
                        'max'  => $fund->max_size,
                        'term' => null,
                        'rate' => null
                    ];
                }

                // Loans
                if ($fund->hasProvisionType('Loans'))
                {
                    $data['quickview'][] = [
                        'name' => 'loans',
                        'min'  => $fund->min_size,
                        'max'  => $fund->max_size,
                        'term' => $fund->investment_term,
                        'rate' => $fund->loans_rate
                    ];
                }

                // Equity
                if ($fund->hasProvisionType('Equity'))
                {
                    $data['quickview'][] = [
                        'name' => 'equity',
                        'min'  => $fund->min_size,
                        'max'  => $fund->max_size,
                        'term' => null,
                        'rate' => null
                    ];
                }

                // Support
                if ($fund->hasProvisionType('Support'))
                {
                    $data['quickview'][] = [
                        'name' => 'support',
                        'min'  => null,
                        'max'  => null,
                        'term' => null,
                        'rate' => null
                    ];
                }

                // Platform
                if ($fund->hasProvisionType('Platform'))
                {
                    $data['quickview'][] = [
                        'name' => 'platform',
                        'min'  => null,
                        'max'  => null,
                        'term' => null,
                        'rate' => null
                    ];
                }

                // Legislation
                if ($fund->hasProvisionType('Legislation'))
                {
                    $data['quickview'][] = [
                        'name' => 'legislation',
                        'min'  => null,
                        'max'  => null,
                        'term' => null,
                        'rate' => null
                    ];
                }

                $response[] = $data;
            }
        }

        return response()->json($response, 200);
    }
}
