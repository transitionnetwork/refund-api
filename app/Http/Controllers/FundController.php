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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $funds = Fund::all();

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
        $values = $request->only(['name']);

        Fund::create($values);

        return response()->json(['message' => 'Fund successfully created.', 'code' => 201], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $fund = Fund::find($id);

        if (!$fund) {
            return response()->json(['message' => 'The fund could not be found.', 'code' => 404], 404);
        }

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
}
