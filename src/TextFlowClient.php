<?php

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
   * @param string recipient Recipient phone number, formatted like `+381617581234`
   * @param string text Message body
   * @return SendMessageResult Result status of the TextFlow Send SMS API call
   * 
   */
  function send_sms(string $recipient, string $text)
  {
    if (strlen($recipient) == 0) {
      return (object) array("ok" => false, "status" => 400, "message" => "You have not specified the recipient. ");
    }
    if (strlen($text) == 0) {
      return (object) array("ok" => false, "status" => 400, "message" => "You have not specified the message body. ");
    }
    if (strlen($this->api_key) == 0) {
      return (object) array("ok" => false, "status" => 400, "message" => "You have not specified the API key. Specify it by calling the useKey function. ");
    }
    $options = array(
      'http' => array(
        'header'  => "Content-type: application/json",
        'method'  => 'POST',
        'content' => json_encode(array('recipient' => $recipient, 'text' => $text, 'apiKey' => $this->api_key))
      )
    );
    $context  = stream_context_create($options);
    $resp = file_get_contents("https://textflow.me/messages/send", false, $context);
    return json_decode($resp);
  }
}
