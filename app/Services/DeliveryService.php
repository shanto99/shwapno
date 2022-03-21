<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Delivery;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DeliveryService {
    public function make_delivery($delivery)
    {
        if(!isset($delivery['CustomerID'])) {
            $customer = (new CustomerService())->createCustomer(
                $delivery['CustomerName'],
                $delivery['CustomerPhone'],
                $delivery['CustomerAddress']
            );
            $delivery['CustomerID'] = $customer->id;
        }

        $delivery['AssignedBy'] = Auth::user()->UserID;
        $delivery['AssignedTime'] = Carbon::now();

        foreach ($delivery as $field => $value) {
            if($field == "CustomerName") unset($delivery["CustomerName"]);
            if($field == "CustomerPhone") unset($delivery["CustomerPhone"]);
            if($field == "CustomerAddress") unset($delivery["CustomerAddress"]);
        }

        return Delivery::create($delivery);
    }

    //    1 - New
    //    2 - Picked
    //    3 - Delivered
    //    4 - Not delivered
    public function update_status($deliveryId, $statusId, $delivery=null)
    {
        if(!$delivery) {
            $delivery = Delivery::find($deliveryId);
        }
        if($delivery) {
            $updatingData['StatusID'] = $statusId;
            if($statusId == 2) {
                $updatingData['StartTime'] = Carbon::now();
            } else if($statusId == 3) {
                $updatingData['EndTime'] = Carbon::now();
            }
            $delivery->update($updatingData);
            return true;
        }
        return false;
    }

    public function verify_otp($deliveryId, $otpCode, $statusId)
    {
        $delivery = Delivery::find($deliveryId);
        if(!$delivery) return false;
        if($delivery->OTP == $otpCode) {
            $delivery->update([
                'OTPVerified' => 1
            ]);

            $this->update_status($deliveryId, $statusId, $delivery);
            return true;
        }
        return false;
    }
}
