<?php

namespace App\Http\Controllers;

use App\ProvisionType;
use Illuminate\Http\Request;

class ProvisionTypeController extends Controller
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
        $provision_types = ProvisionType::all();

        return response()->json(['data' => $provision_types], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param ProvisionType $provision_type
     * @return \Illuminate\Http\Response
     * @internal param int $id
     *
     */
    public function show(ProvisionType $provision_type)
    {
        return response()->json(['data' => $provision_type], 200);
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
