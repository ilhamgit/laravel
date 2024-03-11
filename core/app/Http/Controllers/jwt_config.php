<?php

function GUID()
{
    if (function_exists('com_create_guid') === true)
    {
        return trim(com_create_guid(), '{}');
    }

    return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
}


function jwttoken($username, $wallet_id) {

    $current_time=strtotime(date('H:i'));
    
    $timestamp = $current_time + 60*15;
    
    //echo $timestamp;

    $new_time = date('H:i a', $timestamp);
    
    $key = 'n86Iwf9t$xZ9mhNGo54A*FaaaAfUOIZX';
    $method = 'aes-256-cbc';
    $iv = "B9of31c3b&7*EI0#";
    
    //encrypt Username
    $user_encrypted = base64_encode(openssl_encrypt($username, $method, $key, OPENSSL_RAW_DATA, $iv));
    
    //encrypt Wallet ID
    $wallet_encrypted = base64_encode(openssl_encrypt($wallet_id, $method, $key, OPENSSL_RAW_DATA, $iv));
 
    // Create token header as a JSON string
    $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
    
    // Create token payload as a JSON string
    $payload = json_encode(["username"=>$user_encrypted,"nftaddress"=>$wallet_encrypted,"jti"=>GUID(),"nbf"=>$current_time,"exp"=>$timestamp,"iat"=>$current_time,"iss"=>"MetahorseIssuer","aud"=>"MetahorseAudience"]);
    
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
    /**
     * [encryptString takes custom params and returns ecrypted string in the format specified]
     * @param  [array] $data [username, wallet]
     * @return [string]       [encrypted string]
     */
    function encryptString($data) {

        $key = 'n86Iwf9t$xZ9mhNGo54A*FaaaAfUOIZX';
        $method = 'aes-256-cbc';
        $iv = "B9of31c3b&7*EI0#";

        if ($data) {
            $requiredKeys = ['username', 'wallet'];
            $timestamp = strtotime(date('H:i'));

            $diff = array_diff($requiredKeys, (array_keys($data)));

            if (sizeof($diff) > 0) {
                return 'Missing required parameter';
            }

            //encrypt Username
            $encryptedUsername = base64_encode(openssl_encrypt($data['username'], $method, $key, OPENSSL_RAW_DATA, $iv));
            
            //encrypt Wallet ID
            $encryptedWallet = base64_encode(openssl_encrypt($data['wallet'], $method, $key, OPENSSL_RAW_DATA, $iv));
        
            $final = $encryptedUsername.'|'.$encryptedWallet.'|'.$timestamp;
            $encryptedString  = base64_encode(openssl_encrypt($final, $method, $key, OPENSSL_RAW_DATA, $iv));

            
        }

        return $encryptedString;


    }

?>