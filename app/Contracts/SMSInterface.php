<?php

/**
 * SMS Interface
 *
 * @package     Gofer
 * @subpackage  Contracts
 * @category    SMS Interface
 * @author      Trioangle Product Team
 * @version     2.2.1
 * @link        http://trioangle.com
*/

namespace App\Contracts;

interface SMSInterface
{
	function initialize();
//	function send($to,$text);
	function sendOTP($country_code, $mobile_number);
	function verifyOTP($code,$number);
}