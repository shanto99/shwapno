<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiderController extends Controller
{
    public function get_riders()
    {
        $outletCode = Auth::user()->OutletCode;
        $riders = User::where('UserType', 'Rider')->where('OutletCode', $outletCode)->get();
        return response()->json([
            'data' => [
                'riders' => $riders
            ],
            'status' => 200
        ], 200);
    }
}
