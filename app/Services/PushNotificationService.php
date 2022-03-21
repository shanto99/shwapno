<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Http;

class PushNotificationService {
    public function sendPushNotification($riderId, $deliveryId)
    {
        $server_key = env('FIREBASE_SERVER_KEY');
        $rider = User::where('UserID', $riderId)->first();
        if($rider && $rider->DeviceToken) {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer '.$server_key,
                'Content-Type' => 'application/json'
            ])->post('https://fcm.googleapis.com/fcm/send', [
                'registration_ids' => [$rider->DeviceToken],
                "notification" => [
                    "title" => "Delivery assigned",
                    "body" => [
                        'DeliveryID' => $deliveryId
                    ],
                ]
            ]);

            return $response->ok();
        }
        return false;
    }
}
