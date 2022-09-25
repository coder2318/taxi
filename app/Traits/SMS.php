<?php


namespace App\Traits;


use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

/**
 * Trait SMS
 * @package App\Traits
 */
trait SMS
{

//{
//"messages":
//[
//{
//"recipient":"998900000000",
//"message-id":"abc000000001",
//
//"sms":{
//
//"originator": "3700",
//"content": {
//"text": "Test message"
//}
//}
//}
//]
//}

    public static function sendSms($phone, $text){

        try {

            $data = [
                'messages' => [
                    'recipient' => $phone,
                    'message-id' => "abc000000001",
                    'sms' => [
                        'originator' => '5taxi',
                        'content' => [
                            'text' => $text
                        ]

                    ]
                ]
            ];

            $client = new Client();
            $url   = "http://91.204.239.44/broker-api/send";

            $requestAPI = $client->post( $url, [
                'headers' => ['Content-Type' => 'application/json', 'charset' => 'UTF-8', 'Authorization' => base64_decode('ttt_tmp:d(VJ;d#Be857')],
                'body' => json_encode($data)
            ]);
            Log::stack(['single'])->info(json_encode($requestAPI).$phone);
            return true;
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            Log::stack(['single'])->info($e->getCode(), [$e->getMessage()]);
            return false;
        }
    }

}
