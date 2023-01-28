<?php

namespace TextFlow;

class TextFlow
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
