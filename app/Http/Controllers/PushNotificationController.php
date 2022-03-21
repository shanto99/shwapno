<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PushNotificationController extends Controller
{
    public function store_device_token(Request $request)
    {
        $request->validate([
           'DeviceToken' => 'required',
        ]);

        Auth::user()->update([
            'DeviceToken' => $request->DeviceToken
        ]);

        return response()->json([
            'message' => 'Device token added successfully',
            'status' => 200
        ], 200);

    }
}
