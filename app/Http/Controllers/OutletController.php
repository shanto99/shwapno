<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use Illuminate\Http\Request;

class OutletController extends Controller
{
    public function get_outlets()
    {
        $outlets = Outlet::all();

        return response()->json([
            'outlets' => $outlets,
            'status' => 200
        ], 200);
    }
}
