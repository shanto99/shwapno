<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function get_customer_by_phone($phone)
    {
        $customer = Customer::where('CustomerPhone', 'LIKE', "%{$phone}%")->get();
        return response()->json([
            'data' => [
                'customer' => $customer
            ],
            'status' => 200
        ], 200);
    }
}
