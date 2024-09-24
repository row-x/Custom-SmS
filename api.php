<?php 




if (isset($_POST['apikey']) && isset($_POST['check']) && $_POST['check'] == 'ok') {
   if (!empty($_POST['apikey'])) {
      $api = $_POST['apikey'];
      $url = "https://nomaxsms.xyz/api/check";
      $curl = curl_init($url);
      curl_setopt($curl, CURLOPT_URL, $url);
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      $headers = array("Accept: */*","Content-Type: application/x-www-form-urlencoded",);
      curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
      $data = "apikey=$api";
      curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
      curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
      $result = curl_exec($curl);
      if (curl_errno($curl)) {
          echo 'Error:' . curl_error($curl);
      }
      curl_close($curl);
      $cap = json_decode($result, 1);
      if (isset($cap['response_code']) && $cap['response_code'] == 0) {
         echo $cap['credit'];
      }elseif (isset($cap['response_desc']) && $cap['response_desc'] == 'insufficient credit') {
         echo 'insufficient credit';
      }else{
         echo "DEAD";
      }
   }
   else{
      echo "Api Empty!";
   }
}elseif (isset($_POST['apikey']) && isset($_POST['number']) && isset($_POST['message'])){


   $api = $_POST['apikey'];
   $url = "https://nomaxsms.xyz/api/check";
   $curl = curl_init($url);
   curl_setopt($curl, CURLOPT_URL, $url);
   curl_setopt($curl, CURLOPT_POST, true);
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
   $headers = array("Accept: */*","Content-Type: application/x-www-form-urlencoded",);
   curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
   $data = "apikey=$api";
   curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
   curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
   curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
   $result = curl_exec($curl);
   if (curl_errno($curl)) {
       echo 'Error:' . curl_error($curl);
   }
   curl_close($curl);
   $cap2 = json_decode($result, 1);
   if (isset($cap2['response_code']) && $cap2['response_code'] == 0) {


         $number = $_POST['number'];
         $message = urlencode($_POST['message']);
         $api = $_POST['apikey'];
         $url = "https://nomaxsms.xyz/api/send";
         $curl = curl_init($url);
         curl_setopt($curl, CURLOPT_URL, $url);
         curl_setopt($curl, CURLOPT_POST, true);
         curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
         $headers = array("Accept: */*","Content-Type: application/x-www-form-urlencoded",);
         curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
         $data = "apikey=$api&number=$number&message=$message";
         curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
         curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
         curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
         $result = curl_exec($curl);
         if (curl_errno($curl)) {
             echo 'Error:' . curl_error($curl);
         }
         curl_close($curl);
         $cap = json_decode($result, 1);
         if ($cap['response_desc'] == "success") {
            echo '<span style="width: 100%;margin: 5px 0;color: #9fe163;font-size: 15px;">Message Sent => '.$number.'</span><span id="balance" style="display: none;">'.$cap['credit'].'</span>';
         }else{
            echo '<span style="width: 100%;margin: 5px 0;color: #ff0000;font-size: 15px;">Error => '.$cap['response_desc'].'</span>';
         }


   }elseif (isset($cap2['response_desc']) && $cap2['response_desc'] == 'insufficient credit') {
      echo '<span style="width: 100%;margin: 5px 0;color: #ff0000;font-size: 15px;">Error => insufficient credit</span>';
   }else{
      echo '<span style="width: 100%;margin: 5px 0;color: #ff0000;font-size: 15px;">Error => DEAD API</span>';
   }



}








?>