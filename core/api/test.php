<?php

include 'config.php';

include 'jwt_config.php';


$items=json_encode(array('user'=>'XinYi','wallet'=>'0x701aC5396658C98063f2CCE0501a6747DfaE4360','email'=>'xinyi@folieatrois.com'));

echo $items.'<br>';

$key = 'n86Iwf9t$xZ9mhNGo54A*FaaaAfUOIZX';
$method = 'aes-256-cbc';

// Must be exact 32 chars (256 bit)
// $password = substr(hash('sha256', $password, true), 0, 32);
// echo "Password:" . $password . "\n<br>";

// IV must be exact 16 chars (128 bit)
$iv = "B9of31c3b&7*EI0#";

// av3DYGLkwBsErphcyYp+imUW4QKs19hUnFyyYcXwURU=
$encrypted = base64_encode(openssl_encrypt($items, $method, $key, OPENSSL_RAW_DATA, $iv));

echo $encrypted;

//$encrypted = $items;

// My secret message 1234
//$decrypted = openssl_decrypt(base64_decode($encrypted), $method, $key, OPENSSL_RAW_DATA, $iv);

echo '<hr>';

echo 'jwt = '.jwttoken('MayaKyle', '0x6A91f0D3c462987a03Fa15E457BF5295f8156c1F');

echo '<hr>';


$decrypt_text="uGFm8mLZE8g6AjcisE/k+evvO5wlRPcoLX/09UY80C3aohRECRfY2suk8vTAVxdl";

$key = 'n86Iwf9t$xZ9mhNGo54A*FaaaAfUOIZX';
$method = 'aes-256-cbc';
$iv = "B9of31c3b&7*EI0#";
$decrypted = openssl_decrypt(base64_decode($decrypt_text), $method, $key, OPENSSL_RAW_DATA, $iv);

echo 'decrypt - '.$decrypted;

echo '<hr>';

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

$options = [
  'cost' => 11
];
$user_pass = password_hash(generateRandomString(), PASSWORD_BCRYPT, $options)."\n";

echo $user_pass;

echo '<hr>';

//encrypt Username
$user_encrypted = base64_encode(openssl_encrypt('karen', $method, $key, OPENSSL_RAW_DATA, $iv));
    
    //encrypt Wallet ID
$wallet_encrypted = base64_encode(openssl_encrypt('0x5E7c861114E92ff85DcAfb66Af6b5fdf38f90135', $method, $key, OPENSSL_RAW_DATA, $iv));

echo $user_encrypted.'|'.$wallet_encrypted;

// echo '<hr>';

// $url = 'https://www.metahorse.site/users';

// 		// Collection object
// 		$data = array ("username"=>"$user_encrypted","nftAddress"=>"$wallet_encrypted");

// 		// Initializes a new cURL session
// 		$ch = curl_init($url);
// 		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// 		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
// 		curl_setopt($ch, CURLOPT_POSTFIELDS,  json_encode($data));
// 		curl_setopt($ch, CURLOPT_HTTPHEADER, [
// 		  'Content-Type: application/json'
// 		]);

// 		$response = curl_exec($ch);


// 		// Execute cURL request with all previous settings
// 		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
// 		curl_close($ch);
		
// 		echo $response;

// 		if($httpcode=='200'){
// 			echo 'Data has been updated';
// 		}else{
// 			echo 'Data has failed to update';
// 		}

echo '<hr>';

$dateStr = date('h:i:s');
$timezone = 'Asia/Kuala_Lumpur';

$date = new DateTime($dateStr, new DateTimeZone($timezone));

$ntimestamp = $date->format('U');

$current_time=strtotime("now") + 60*60*8;


$timestamp = strtotime("now") + 60*15;


    
echo time();
echo '<br>';
echo $current_time;

$enc_data=array('MayaKyle','0x6A91f0D3c462987a03Fa15E457BF5295f8156c1F');

$enc=encryptString($enc_data);

echo '
<div class="embed-responsive embed-responsive-1by1">
  <iframe class="w-100 embed-responsive-item" src="https://webgltest-mh.s3.amazonaws.com/Main/CanteenWebGL/index.html?t='.$enc.'" width="900px" height="700px"></iframe>
</div>
';

//echo $new_time;

echo '<hr>';

?>