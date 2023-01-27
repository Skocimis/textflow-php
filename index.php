<?php
    $url = "https://textflow.me/messages/send";
    $data = array('recipient' => '+381637443242', 'text' => 'Poruka iz php', 'apiKey'=>'N70NdGmKlHcd4MuCg4ChMWrC45cE0CQHBWPiKlFeR3BmDVLgEejtQoGvyVy7yVqL');
    
    
    $ch = curl_init();

    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_POST, true);
    curl_setopt($ch,CURLOPT_POSTFIELDS, http_build_query($data));

    curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
    $result = curl_exec($ch);
    echo $result;
?>