<?php

/**
 * Send sms via Twillio
 *
 * @package     Gofer
 * @subpackage  Services
 * @category    Auth Service
 * @author      Trioangle Product Team
 * @version     2.2
 * @link        http://trioangle.com
*/

namespace App\Services\SMS;

use App\Contracts\SMSInterface;
use App\Models\ConfirmationCode;
use App\Models\Country;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;


class SMS implements SMSInterface
{
	private $client,$verify,$guzzleClient;

	

		/**
     * Initialize Twillo credentials
     *
     * @return void
     */
	public function initialize()
	{
        $this->guzzleClient = new Client(['base_uri' => 'http://91.204.239.44/broker-api/']);

	}

	/**
     * Send OTP message
     *
     * @param String $phone_number
     * @return bool
     */
	public function sendOTP($country_code, $mobile_number)
	{
        $data = ConfirmationCode::generateOTP($country_code, $mobile_number);
		try {

            $guzzleClient = new Client(['base_uri' => 'http://91.204.239.44/broker-api/']);

            $requestAPI = $guzzleClient->post('send', [
                'headers' => ['Content-Type' => 'application/json', 'Authorization' => 'Basic '.base64_encode('ttt_tmp:d(VJ;d#Be857')],
                'body' => $this->smsBody($country_code.$mobile_number, $data)
            ]);
            return ($requestAPI->getStatusCode() == 200);
		}
		catch(\Exception $e) {
            Log::stack(['single'])->info($e->getCode(), [$e->getMessage(), $data]);
			return false;
		}
	}

	/**
     * Verify OTP number
     *
     * @param String $phone_number, String $verification_code
     * @return Array SMS Response
     */
	public function verifyOTP($code, $phone_number)
	{
		try {

			$verification = $this->verify->verificationChecks->create($verification_code, array('to'=>$phone_number));

			if($verification->valid)
				return array('status_code' => 1,'message'=>'Success','status'=>true);
			else
				return array('status_code' => 0,'message'=>__('messages.signup.wrong_otp'),'status'=>false);
		}
		catch(\Exception $e) {
			return array('status_code' => 0,'message'=>__('messages.signup.wrong_otp'),'status'=>false);
		}
	}

//	/**
//     * Send Text message to mobile
//     *
//     * @param String $phone_number, String $verification_code
//     * @return Array SMS Response
//     */
//	public function send($phone_number, $text='',$verification_code=false)
//	{
//		$this->initialize();
//		if($text){
//			$result = $this->SendTextMessage($phone_number,$text);
//		}
//		else if($verification_code) {
//			$result = $this->verifyOTP($phone_number, $verification_code);
//		} else {
//			$result = $this->sendOTP($phone_number);
//		}
//		return $result;
//	}


	public function smsBody($to, $text){
	    return json_encode([
            'messages' => [
                [
                    'recipient' => $to,
                    'message-id' => "abc000000001",
                    'sms' => [
                        'originator' => '3700',
                        'content' => [
                            'text' => $text
                        ]
                    ]
                ]

            ]
        ]);
    }



}

//{"messages":[{"recipient":"998901679102","message-id":"abc000000002","sms":{"originator": "3700","content":{"text":"test"}}}]}
//{"messages":[{"recipient":"998901679102","message-id":"abc000000001","sms":{"originator": "3700","content": {"text": "Test message"}}}]}