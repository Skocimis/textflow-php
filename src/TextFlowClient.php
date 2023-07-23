<?php

namespace TextFlow\SMSApi;

/**
 * Information about the delivered message
 * @property string $to 
 * @property string $content
 * @property string $country_code
 * @property float $price
 * @property integer $timestamp
 */
class SendMessageData
{
}

/**
 * Additional data about the verification
 * @property string $verification_code 
 * @property integer $expires
 * @property string $message_text
 */
class VerifyPhoneData
{
}

/**
 * Result status of the TextFlow Send SMS API call
 * @property boolean $ok True if the message was successfully sent, false otherwise. 
 * @property integer $status Status code
 * @property string $message Status message
 * @property SendMessageData $data If the message was sent successfully, additional data about the message is returned
 */
class SendMessageResult
{
}

/**
 * Result status of the TextFlow Send verification code API call
 * @property boolean $ok True if the code was successfully sent, false otherwise. 
 * @property integer $status Status code
 * @property string $message Status message
 * @property VerifyPhoneData $data If the code was sent successfully, additional data about the message is returned
 */
class VerifyPhoneResult
{
}

/**
 * Result status of the TextFlow verify code API call
 * @property boolean $ok True if the request was ok, but you should use $valid to check for validation
 * @property boolean $valid True if the message was successfully sent, false otherwise. 
 * @property integer $status Status code
 * @property string $message Status message
 * @property string $valid_code Code that is valid, if it exists
 * @property integer $expires Code expiration timestamp
 */
class VerifyCodeResult
{
}

/**
 * TextFlowClient object is used to send messages.
 */
class TextFlowClient
{
  private string $api_key;
  function __construct(string $api_key)
  {
    $this->api_key = $api_key;
  }
  function use_key(string $key)
  {
    $this->api_key = $key;
  }

  /**
   * Method that is used to send an SMS. 
   * @param string phone_number Recipient phone number, formatted like `+381617581234`
   * @param string text Message body
   * @return SendMessageResult Result status of the TextFlow Send SMS API call
   * 
   */
  function send_sms(string $phone_number, string $text)
  {
    if (strlen($phone_number) == 0) {
      return (object) array("ok" => false, "status" => 400, "message" => "You have not specified the recipient phone number. ");
    }
    if (strlen($text) == 0) {
      return (object) array("ok" => false, "status" => 400, "message" => "You have not specified the message body. ");
    }
    if (strlen($this->api_key) == 0) {
      return (object) array("ok" => false, "status" => 400, "message" => "You have not specified the API key. Specify it by calling the useKey function. ");
    }
    $options = array(
      'http' => array(
        'header'  => "Content-type: application/json\r\nAuthorization: Bearer " . $this->api_key,
        'method'  => 'POST',
        'content' => json_encode(array('phone_number' => $phone_number, 'text' => $text)),
        'ignore_errors' => true,
      )
    );
    $context  = stream_context_create($options);
    $resp = file_get_contents("https://textflow.me/api/send-sms", false, $context);
    return json_decode($resp);
  }



  /**
   * Method that is used to send ан SMS with a verification code. 
   * @param string phone_number Phone number to verify, formatted like `+381617581234`
   * @param string [service_name] What the user will see in the verification message, if the `service_name` is `"Guest"`, they would get the message: `"Your verification code for Guest is: CODE"`. Default is none.
   * @param integer [seconds] How many seconds is the code valid for. Default is 10 minutes. Maximum is one day.
   * @return VerifyPhoneResult Result status of the TextFlow Send verification code API call
   * 
   */
  function send_verification_sms(string $phone_number, string $service_name = "", int $seconds = 600)
  {
    if (strlen($phone_number) == 0) {
      return (object) array("ok" => false, "status" => 400, "message" => "You have not specified the phone number. ");
    }
    if (strlen($this->api_key) == 0) {
      return (object) array("ok" => false, "status" => 400, "message" => "You have not specified the API key. Specify it by calling the useKey function. ");
    }
    $options = array(
      'http' => array(
        'header'  => "Content-type: application/json\r\nAuthorization: Bearer " . $this->api_key,
        'method'  => 'POST',
        'content' => json_encode(array('phone_number' => $phone_number, 'service_name' => $service_name, 'seconds' => $seconds)),
        'ignore_errors' => true,
      )
    );
    $context  = stream_context_create($options);
    $resp = file_get_contents("https://textflow.me/api/send-code", false, $context);
    return json_decode($resp);
  }

  /**
   * Method that is used to check if the code that the user has entered is valid. 
   * @param string phone_number Phone number to verify the code for, formatted like `+381617581234`
   * @param string code Code to verify
   * @return VerifyCodeResult Result status of the TextFlow Send SMS API call
   * 
   */
  function verify_code(string $phone_number, string $code)
  {
    if (strlen($phone_number) == 0) {
      return (object) array("ok" => false, "status" => 400, "message" => "You have not specified the phone number. ");
    }
    if (strlen($code) == 0) {
      return (object) array("ok" => false, "status" => 400, "message" => "You have not specified the verification code. ");
    }
    if (strlen($this->api_key) == 0) {
      return (object) array("ok" => false, "status" => 400, "message" => "You have not specified the API key. Specify it by calling the useKey function. ");
    }
    $options = array(
      'http' => array(
        'header'  => "Content-type: application/json\r\nAuthorization: Bearer " . $this->api_key,
        'method'  => 'POST',
        'content' => json_encode(array('phone_number' => $phone_number, 'code' => $code)),
        'ignore_errors' => true,
      )
    );
    $context  = stream_context_create($options);
    $resp = file_get_contents("https://textflow.me/api/verify-code", false, $context);
    return json_decode($resp);
  }
}
