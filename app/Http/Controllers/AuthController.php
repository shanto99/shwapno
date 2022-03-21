<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'UserName' => 'required|unique:UserManager',
            'Phone' => 'required|unique:UserManager',
            'Password' => 'required',
            'UserNID' => 'unique:UserManager',
            'UserLicense' => 'unique:UserManager',
            'UserType' => 'required',
            'UserID' => 'required|unique:UserManager'
        ]);

        $outletCode = Auth::user()->OutletCode;
        $user = User::create([
            'UserName' => $request->UserName,
            'Email' => $request->Email,
            'Phone' => $request->Phone,
            'UserType' => $request->UserType,
            'UserNID' => $request->UserNID,
            'UserLicense' => $request->UserLicense,
            'Password' => bcrypt($request->Password),
            'UserID' => $request->UserID,
            'OutletCode' => $outletCode
        ]);

        return response()->json([
            'data' => [
                'user' => $user
            ],
            'status' => 200
        ], 200);
    }

    public function login(Request $request)
    {
        $request->validate([
            'UserName' => 'required',
            'Password' => 'required'
        ]);

        $user = User::where('UserID', $request->UserName)->first();
        if($user && Hash::check($request->Password, $user->Password)) {
            $token = $user->createToken($request->UserName)->plainTextToken;
            return response()->json([
               'data' => [
                   'token' => $token,
                   'user' => $user
               ],
                'status' => 200
            ], 200);
        }

        return response()->json([
            'errors' => [
                'Incorrect credentials'
            ],
            'status' => 401
        ], 401);
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
        return response()->json([
            'message' => 'Logged out successfully',
            'status' => 200
        ], 200);
    }

    public function get_user()
    {
        $user = Auth::user();
        return response()->json([
           'data' => [
               'user' => $user
           ],
           'status' => 200
        ], 200);
    }
}
