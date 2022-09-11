<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed',
        ]);

        if ($validator->fails()) {
            return response([
                'user' => null,
                'message' => 'Validation error.',
                'errors' => $validator->messages(),
            ], 400);
        }

        Log::debug([$request]);

        $user = User::create($request->all());
        $token = $user->createToken('token');

        return response([
            "user" => $user,
            "message" => "Register successful",
            'token' => $token->plainTextToken,
        ], 200);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response([
                'user' => null,
                'message' => 'Validation error.',
                'errors' => $validator->messages(),
            ], 400);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                "user" => null,
                'errors' => [
                    'login' => ['Wrong combination']
                ],
                "message" => "Wrong combination.",
            ], 400);
        }

        $token = $user->createToken('token');

        return response([
            "user" => $user,
            "message" => "Login successful",
            'token' => $token->plainTextToken,
        ], 200);
    }

    public function logout(Request $request)
    {
        $user = auth()->user();
        $user->tokens()->delete();

        return response([
            "user" => $user,
            "message" => "Logout.",
        ], 200);
    }

    public function reservations(Request $request)
    {
        $reservations = auth()->user()->reservations;

        return response([
            "reservations" => $reservations,
            "message" => "Success.",
        ], 200);
    }

    public function rides(Request $request)
    {
        $rides = auth()->user()->rides;

        return response([
            "rides" => $rides,
            "message" => "Success.",
        ], 200);
    }
}
