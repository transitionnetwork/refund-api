<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('oauth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $funds = User::all();

        return response()->json(['data' => $funds], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateUserRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        $values = $request->only([
            'first_name',
            'last_name',
            'email',
            'password',
        ]);

        User::create($values);

        return response()->json(['message' => 'User successfully created.', 'code' => 201], 201);
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
     * @param UpdateUserRequest $request
     * @param int               $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
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
