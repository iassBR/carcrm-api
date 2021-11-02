<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function auth(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => trans('messages.invalid_credentials')], 404);
        }

        $token = $user->createToken($request->device_name)->plainTextToken;

        return response()->json(['token' => $token]);
    }

    public function me(Request $request)
    {
        $user = $request->user();

        return response()->json(['user' => $user]);
    }

    public function logout(Request $request)
    {
        $user = $request->user();

        // Revoke all tokens user...
        $user->tokens()->delete();

        return response()->json([], 204);
    }
}
