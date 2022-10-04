<?php

/**
 * OTP Helper
 *
 * @package     Gofer
 * @subpackage  Controller
 * @category    Helper
 * @author      Trioangle Product Team
 * @version     2.2.1
 * @link        http://trioangle.com
 */
namespace App\Http\Helper;

class OtpHelper
{
	/**
	 * Send OTP
	 *
	 * @param integer $country_code
	 * @param integer $mobile_number
	 * @return Array $response
	 */
	public function sendOtp($country_code, $mobile_number)
	{
        $sms_gateway = resolve("App\Contracts\SMSInterface");
        return $sms_gateway->sendOTP($country_code, $mobile_number);
    }


		
	

	/**
	 * Resend OTP
	 *
	 * @return Array $response
	 */
	public function resendOtp()
	{
		if(canDisplayCredentials()){
			$response = [
				'status_code' => 1,
				'message' => 'success',
				'signup_otp' => "1244",
			];
		}

		$otp = rand(1000,9999);
        $text = 'Your OTP number is '.$otp;
        $to = '+'.session('signup_country_code').session('signup_mobile');
        $sms_gateway = resolve("App\Contracts\SMSInterface");
        $response = $sms_gateway->send($to);

        if ($response['status_code']==1) {
            session(['signup_otp' => $otp]);
            $response['message'] = trans('messages.signup.otp_resended');
        }

		return $response;
	}



	public function sendText($country_code, $mobile_number){
        $to = '+'.$country_code.$mobile_number;
        $sms_gateway = resolve("App\Contracts\SMSInterface");
        $response = $sms_gateway->SendTextMessage($to, 'testnew');
        if($response)
            return  [
                'status_code' => 1,
                'message' => 'success',
            ];
            return  [
                'status_code' => 0,
                'message' => 'error',
            ];
    }
}