<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserFormRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function store(RegisterUserFormRequest $request)
    {
        $attributes = $request->all();

        $attributes['password'] = Hash::make($request->password);

        $today = Carbon::now();

        $attributes['next_expiration'] = $today->addDays(7);

        $attributes['delete_account'] = $today->addDays(15);

        $user = User::create($attributes);

        return response()->json(['token' => $user->createToken('auth-api')->plainTextToken], 200);


    }
}
