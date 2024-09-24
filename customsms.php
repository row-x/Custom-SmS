<?php
$phn = $_REQUEST["phone"];
$sms = $_REQUEST["sms"];
$url = 'https://ap.paymasterbd.net/login_registration/';

$headers = array(
    'Host: ap.paymasterbd.net',
    'Content-Type: application/x-www-form-urlencoded',
    'Accept-Encoding: gzip',
    'User-Agent: okhttp/3.14.9'
);

$data = array(
    'phone_number' => $phn,
    'fcm_key' => '',
    'device_id' => '97bfda77edefe5',
    'sms_hash_code' => $sms
);

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
curl_close($ch);

echo $response;
?>