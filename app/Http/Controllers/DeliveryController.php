<?php

namespace App\Http\Controllers;

use App\Events\AssignRiderEvent;
use App\Models\Delivery;
use App\Models\Location;
use App\Models\User;
use App\Services\DeliveryService;
use App\Services\PushNotificationService;
use App\Services\SmsService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function make_delivery(Request $request)
    {
        $deliveryData = $request->only([
            'CustomerID',
            'InvoiceID',
            'DeliveryAddress',
            'StatusID',
            'Lat',
            'Lng',
            'CustomerName',
            'CustomerPhone',
            'CustomerAddress',
            'SpecialInstruction',
            'RiderID'
        ]);

        $delivery = (new DeliveryService())->make_delivery($deliveryData);

//        event(new AssignRiderEvent([
//            'DeliveryID' => $delivery->DeliveryID,
//            'RiderID' => $delivery->RiderID
//        ]));
        $sent = (new PushNotificationService())->sendPushNotification($request->RiderID, $request->InvoiceID);
        return response()->json([
            'data' => [
                'delivery' => $delivery,
                'notificationSent' => $sent,
                'status' => 200
            ]
        ], 200);
    }

    public function all_deliveries($from=null, $to=null)
    {
        if($from) $from = Carbon::createFromFormat('Y-m-d', $from)->startOfDay();
        if($from && $to) {
            $to = Carbon::createFromFormat('Y-m-d', $to)->endOfDay();
        } else if($from) {
            $to = $from->copy()->endOfDay();
        }

        if($from && $to) {
            $deliveries = Delivery::with('Customer')->whereBetween('AssignedTime', [$from, $to])->get();
        } else {
            $deliveries = Delivery::with('Customer')->get();
        }

        return response()->json([
           'data' => [
               'deliveries' => $deliveries
           ],
            'status' => 200
        ], 200);
    }

    public function update_delivery_status(Request $request)
    {
        $request->validate([
            'DeliveryID' => 'required',
            'StatusID' => 'required'
        ]);

        $isUpdated = (new DeliveryService())->update_status($request->DeliveryID, $request->StatusID);

        if($isUpdated) {
            return response()->json([
                'message' => 'Delivery status updated',
                'status' => 200
            ], 200);
        }

        return response()->json([
           'message' => 'Could not update status',
            'status' => 400
        ], 400);

    }

    public function get_rider_delivery($riderId)
    {
        $rider = User::find($riderId);
        if(!$rider) return response()->json([
            'errors' => [
                'Rider not found'
            ],
            'status' => 400
        ], 400);

        $deliveries = $rider->Deliveries;
        return response()->json([
            'data' => [
                'deliveries' => $deliveries
            ],
            'status' => 200
        ], 200);
    }

    public function send_sms(Request $request)
    {
        (new SmsService())->send_sms('01609295397', 'Hello shanto');
    }

    public function save_delivery_location(Request $request)
    {
        $request->validate([
          'DeliveryID' => 'required',
          'Lat' => 'required',
          'Lng' => 'required'
        ]);

        Location::create($request->only(['DeliveryID', 'Lat', 'Lng']));

        return response()->json([
            'status' => 200
        ], 200);
    }

    public function make_undelivered()
    {
        $undeliveredOrders = Delivery::where('created_at', '>=', Carbon::now()->subDay())->where('StatusID','!=', '3')->get();
        foreach ($undeliveredOrders as $order) {
            $order->update([
               'StatusID' => 4
            ]);
        }

        return response('OK');
    }
}
