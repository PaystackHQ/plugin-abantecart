<?php

function verify_txn($code,$key){

  $contextOptions = array(
      'ssl' => array(
          'verify_peer' => true,
          'ciphers' => 'HIGH:!SSLv2:!SSLv3',
      ),
      'http'=>array(
        'method'=>"GET",
        'header'=> array("Authorization: Bearer ".$key."\r\n","Connection: close\r\n","User-Agent: test\r\n)")
      )
  );

  $context = stream_context_create($contextOptions);
  $url = 'https://api.paystack.co/transaction/verify/'.$code;
  $request = file_get_contents($url, false, $context);
  $result = json_decode($request);
  return $result;
}
