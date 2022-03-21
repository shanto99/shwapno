<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatusController extends Controller
{
    public function all_status()
    {
        $statuses = DB::table('Statuses')->get();
        return response()->json([
           'data' => [
               'all_status' => $statuses
           ],
           'status' => 200
        ], 200);
    }
}
