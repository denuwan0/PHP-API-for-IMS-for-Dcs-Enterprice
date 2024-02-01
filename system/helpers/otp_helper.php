<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once('vendor/notifylk/notify-php/autoload.php');
/**
 * CodeIgniter Email Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		EllisLab Dev Team
 * @link		https://codeigniter.com/userguide3/helpers/email_helper.html
 */

// ------------------------------------------------------------------------

if ( ! function_exists('sendSms'))
{
	function sendSms($to,$message)
	{
			

		$api_instance = new NotifyLk\Api\SmsApi();
		$user_id = "25813"; // string | API User ID - Can be found in your settings page.
		$api_key = "YGQoZ6St51nVK7Djzv9Y"; // string | API Key - Can be found in your settings page.
		//$message = "Testing"; // string | Text of the message. 320 chars max.
		//$to = "94716198852"; // string | Number to send the SMS. Better to use 9471XXXXXXX format.
		$sender_id = "NotifyDEMO"; // string | This is the from name recipient will see as the sender of the SMS. Use \\\"NotifyDemo\\\" if you have not ordered your own sender ID yet.
		$contact_fname = "contact_fname_example"; // string | Contact First Name - This will be used while saving the phone number in your Notify contacts.
		$contact_lname = "contact_lname_example"; // string | Contact Last Name - This will be used while saving the phone number in your Notify contacts.
		$contact_email = "example@domain.com"; // string | Contact Email Address - This will be used while saving the phone number in your Notify contacts.
		$contact_address = "contact_address_example"; // string | Contact Physical Address - This will be used while saving the phone number in your Notify contacts.
		$contact_group = 0; // int | A group ID to associate the saving contact with

		try {
		$api_instance->sendSMS($user_id, $api_key, $message, $to, $sender_id, $contact_fname, $contact_lname, $contact_email, $contact_address, $contact_group);
		} catch (Exception $e) {
		echo 'Exception when calling SmsApi->sendSMS: ', $e->getMessage(), PHP_EOL;
		}
		
		
	}
}

// ------------------------------------------------------------------------

