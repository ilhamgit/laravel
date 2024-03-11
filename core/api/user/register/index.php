<?php

include '../../config.php';

include '../../jwt_config.php';

$jsonobj='';

if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
 $jsonobj = file_get_contents('php://input'); //Be aware that the stream can only be read once
 
 //echo $jsonobj;
}else{
    die('no data');
}

$obj = json_decode($jsonobj);

//print_r($obj);


$key = 'n86Iwf9t$xZ9mhNGo54A*FaaaAfUOIZX';
$method = 'aes-256-cbc';

// Must be exact 32 chars (256 bit)
// $password = substr(hash('sha256', $password, true), 0, 32);
// echo "Password:" . $password . "\n<br>";

// IV must be exact 16 chars (128 bit)
$iv = "B9of31c3b&7*EI0#";

// av3DYGLkwBsErphcyYp+imUW4QKs19hUnFyyYcXwURU=
//$encrypted = base64_encode(openssl_encrypt($plaintext, $method, $key, OPENSSL_RAW_DATA, $iv));

$encrypted = $obj->signature;

// My secret message 1234
$decrypted = openssl_decrypt(base64_decode($encrypted), $method, $key, OPENSSL_RAW_DATA, $iv);

//echo $decrypted;


$userdata=json_decode($decrypted,1);

//print_r($userdata);

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

//$hashed_random_password = Hash::make(str_random(8));

$insert="INSERT INTO `users`(`wallet_id`, `username`, `email`, `country_code`, `ref_by`, `balance`, `password`, `status`, `ev`, `sv`,`ts`, `tv`) VALUES ('".$userdata['wallet']."','".$userdata['user']."','".$userdata['email']."','MY','0','0','".$user_pass."','1','1','1','0','1')";

if($mysqli->query($insert) === TRUE){
    
        $key = 'n86Iwf9t$xZ9mhNGo54A*FaaaAfUOIZX';
        $method = 'aes-256-cbc';
        $iv = "B9of31c3b&7*EI0#";
        $user_encrypted = base64_encode(openssl_encrypt($userdata['user'], $method, $key, OPENSSL_RAW_DATA, $iv));
        $wallet_encrypted = base64_encode(openssl_encrypt($userdata['wallet'], $method, $key, OPENSSL_RAW_DATA, $iv));
    
    
        $url = 'https://www.metahorse.site/users';

		// Collection object
		$data = array ("username"=>"$user_encrypted","nftAddress"=>"$wallet_encrypted");

		// Initializes a new cURL session
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS,  json_encode($data));
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
		  'Content-Type: application/json'
		]);

		$response = curl_exec($ch);


		// Execute cURL request with all previous settings
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		
		//echo $response;

		if($httpcode=='200'){
			http_response_code(200);
            header("Content-Type: application/json;charset=utf-8;");
        
        	$result=array('saved'=>'true','message'=>'User created!');
		}else{
			http_response_code(422);
            header("Content-Type: application/json;charset=utf-8;");
        
        	$result=array('saved'=>'false','message'=>'User cannot send to the Web API');
		}


	echo json_encode($result);

} else {

	http_response_code(422);
    header("Content-Type: application/json;charset=utf-8;");

	$result=array('saved'=>'false','message'=>'User cannot created!');

	echo json_encode($result);

}

?>