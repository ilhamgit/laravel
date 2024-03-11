<?php
//start
task1();

 function task1()
  {
        //match date
        $date = date('Y-m-d', strtotime('+1 day', time()));
        
        $id = 1;
        
        
        /**generate**/
        $token = generateToken();
        $jwt = generateJwt($token);
        /**generate ends**/
        
        /**make folder**/

        $schedulerLog = 'scheduler_log';
        if (!file_exists($schedulerLog.'/')) {
        mkdir($schedulerLog.'/', 0777, true);
        }
        $innerLog = $schedulerLog.'/validate/'.$id;
        $innerLog2 = $schedulerLog.'/generate/'.$id;
        
        if (!file_exists($innerLog.'/')) {
        mkdir($innerLog.'/', 0777, true);
        }
        
        if (!file_exists($innerLog2.'/')) {
        mkdir($innerLog2.'/', 0777, true);
        }

   
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.metahorse.site/matches/'.$date.'/'.$id.'/validate');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        'Authorization: Bearer '.$jwt
        ]);
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);
        
        file_put_contents($innerLog.'/'.date('Y-m-d_H:i:s').'.txt', $response);
        
        if ($response == true) {
        //generate matches
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.metahorse.site/matches/'.$date.'/generate');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          "Content-Type: application/json",
          'Authorization: Bearer '.$jwt
        ]);
        curl_setopt($ch, CURLOPT_POST, 1);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $dataPushCompile);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response2 = curl_exec($ch);
        curl_close($ch);
        
        file_put_contents($innerLog2.'/'.date('Y-m-d_H:i:s').'.txt', $response2);
      }

        return $response;
     
   }
   
   function generateToken() {

        $key ='n86Iwf9t$xZ9mhNGo54A*FaaaAfUOIZX';
        $fixedToken = '@dm1nm3_@m@sk$XSxQm2#unW0hQ7Dd0@Sjr';
        $method = 'aes-256-cbc';
        $iv = "B9of31c3b&7*EI0#";
        $timestamp = strtotime(date('H:i'));

        //encrypt token
        $encryptedToken = base64_encode(openssl_encrypt($fixedToken, $method, $key, OPENSSL_RAW_DATA, $iv));

    
        $final = $encryptedToken.'|'.$timestamp;
        $encryptedString  = base64_encode(openssl_encrypt($final, $method, $key, OPENSSL_RAW_DATA, $iv));


        return $encryptedString;


    }
    
    function generateJwt($token)
    {
        $current_time=strtotime(date('H:i'));
    
        $timestamp = $current_time + 60*15;
           // Create token header as a JSON string
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        
        // Create token payload as a JSON string
        $payload = json_encode(["tokenkey"=>$token,"jti"=>GUID(),"nbf"=>$current_time,"exp"=>$timestamp,"iat"=>$current_time,"iss"=>"MetahorseIssuer","aud"=>"MetahorseAudience"]);
    
        
        // Encode Header to Base64Url String
        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        
        // Encode Payload to Base64Url String
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
        
        // Create Signature Hash
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, 'zvvQK057n5#AzuBo', true);
        
        // Encode Signature to Base64Url String
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
        
        // Create JWT
        $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    
        return $jwt;
    }
    
    function GUID()
    {
        if (function_exists('com_create_guid') === true)
        {
            return trim(com_create_guid(), '{}');
        }
    
        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }
?>