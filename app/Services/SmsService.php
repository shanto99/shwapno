<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class SmsService {
    private $apikey='$2y$10$zqmgq8liZZn.TopicM55s.fZu1sVYO8QHjZkf92BrxZESh9XW6.S2';
    private $apiUrl = "http://connect.primesoftbd.com/smsapi/non-masking";

    public function send_sms($phoneNumber, $body)
    {
        $fullNumber = '880' . substr(preg_replace('/\D/', '', $phoneNumber), -10);
        $respnose = Http::get($this->apiUrl, [
           'api_key' => $this->apikey,
            'smsType' => 'text',
            'mobileNo' => $fullNumber,
            'smsContent' => $body
        ]);

        return $respnose->ok();
    }
}
