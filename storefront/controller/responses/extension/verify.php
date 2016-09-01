<?php

function verify_transaction($token, $amount, $currency, $private_key){

    $data = array(
        'token' => $token,
        'amount' => $amount,
        'currency' => $currency
    );
    $data_string = json_encode($data);

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://checkout.simplepay.ng/v1/payments/verify/');
    curl_setopt($ch, CURLOPT_USERPWD, $private_key . ':');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_string)
    ));

    $verify_count = 1;
    $response = do_curl($ch);
    $verified = valid_response($response);
    while (!$verified && $verify_count < 3) {
        $response = do_curl($ch);
        $verified = valid_response($response);
        $verify_count += 1;
    }

    curl_close($ch);

    return array(
        'verified' => $verified,
        'response' => $response['json_response']
    );

}

function do_curl($ch){

    $curl_response = curl_exec($ch);
    $curl_response = preg_split("/\r\n\r\n/", $curl_response);
    $response_content = $curl_response[1];

    return array(
        'response_code' => curl_getinfo($ch, CURLINFO_HTTP_CODE),
        'json_response' => json_decode(chop($response_content), true)
    );

}

function valid_response($response){

    return $response['response_code'] == '200' ||
    $response['response_code'] == '201' ||
    $response['json_response']['response_code'] == '20000';

}