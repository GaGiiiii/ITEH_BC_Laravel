<?php

namespace App\Http\Controllers;

use App\Models\Ride;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rides = Ride::with('user')->get();

        return response()->json([
            "rides" => $rides,
            "message" => "Success",
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'start_location' => 'required|string|max:100',
            'end_location' => 'required|string|max:100',
            'date' => 'required|string',
            'space' => 'required|integer|min:1|max:7',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'ride' => null,
                'message' => 'Validation error.',
                'errors' => $validator->messages(),
            ], 400);
        }

        $request->request->add(['user_id' => auth()->user()->id]); //add request
        $ride = Ride::create($request->all());

        return response()->json([
            "ride" => $ride,
            "message" => "Success.",
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ride = Ride::find($id);

        if (!$ride) {
            return response()->json([
                'ride' => null,
                'message' => 'Not found.',
            ], 404);
        }

        return response()->json([
            "ride" => $ride,
            "message" => "Success.",
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $ride = Ride::find($id);

        if (!$ride) {
            return response([
                'ride' => null,
                'message' => 'Not found.',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'start_location' => 'required|string|max:100',
            'end_location' => 'required|string|max:100',
            'date' => 'required|string',
            'space' => 'required|integer|min:1|max:7',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'ride' => null,
                'message' => 'Validation error.',
                'errors' => $validator->messages(),
            ], 400);
        }

        $request->request->add(['user_id' => auth()->user()->id]); //add request
        $ride = $ride->update($request->all());

        return response()->json([
            "ride" => $ride,
            "message" => "Success.",
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ride = Ride::find($id);

        if (!$ride) {
            return response()->json([
                'ride' => null,
                'message' => 'Not found.',
            ], 404);
        }

        $ride->delete();

        return response()->json([
            "ride" => $ride,
            "message" => "Success.",
        ], 200);
    }
}
