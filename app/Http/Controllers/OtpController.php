<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Delivery;
use App\Services\DeliveryService;
use App\Services\SmsService;
use Illuminate\Http\Request;

class OtpController extends Controller
{
    public function send_otp(Request $request)
    {
        $request->validate([
           'DeliveryID' => 'required'
        ]);

        $delivery = Delivery::find($request->DeliveryID);
        if(!$delivery) {
            return response()->json([
                'errors' => [
                    'No delivery found'
                ],
                'status' => 400
            ], 400);
        }
        try{
            $customer = $delivery->Customer;

            $otp = (string)random_int(100000, 999999);

            $delivery->update([
                'OTP' => $otp
            ]);

            $sentOtp = (new SmsService())->send_sms($customer->CustomerPhone, $otp);
            if($sentOtp) {
                return response()->json([
                    'message' => 'OTP sent successfully'
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Could not send OTP'
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'errors' => [
                    $e->getMessage()
                ]
            ], 500);
        }

    }

    public function verify_otp(Request $request)
    {
        $request->validate([
            'DeliveryID' => 'required',
            'OTP' => 'required',
            'StatusID' => 'required'
        ]);

        $isVerified = (new DeliveryService())->verify_otp($request->DeliveryID, $request->OTP, $request->StatusID);

        if($isVerified) {
            return response()->json([
               'message' => 'Status updated to delivered',
               'status' => 200
            ], 200);
        } else {
            return response()->json([
                'message' => 'Could not verify OTP',
                'status' => 400
            ], 400);
        }

    }
}
