<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Ride;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ride = Ride::find($request->ride_id);

        if (!$ride) {
            return response([
                'reservation' => null,
                'message' => 'Ride not found.',
            ], 400);
        }

        $validator = Validator::make($request->all(), [
            'ride_id' => 'required|integer',
            'space' => 'required|integer|max:7|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'reservation' => null,
                'message' => 'Validation error.',
                'errors' => $validator->messages(),
            ], 400);
        }

        $alreadyExist = Reservation::where('ride_id', $request->ride_id)->where('user_id', auth()->user()->id)->first();

        if ($alreadyExist) {
            return response()->json([
                'reservation' => null,
                'message' => 'Validation error.',
                'errors' => [
                    'duplicate' => ['Reservation already exist.']
                ],
            ], 400);
        }

        if ($request->space > $ride->space) {
            return response()->json([
                'reservation' => null,
                'message' => 'Validation error.',
                'errors' => [
                    'space' => ['Not enough space.']
                ],
            ], 400);
        }

        $request->request->add(['user_id' => auth()->user()->id]); //add request
        $reservation = Reservation::create($request->all());

        return response()->json([
            "reservation" => $reservation,
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reservation = Reservation::find($id);

        if (!$reservation) {
            return response()->json([
                'reservation' => null,
                'message' => 'Not found.',
            ], 404);
        }

        $reservation->delete();

        return response()->json([
            "reservation" => $reservation,
            "message" => "Success.",
        ], 200);
    }
}
