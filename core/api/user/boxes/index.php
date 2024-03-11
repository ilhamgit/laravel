<?php

include '../../config.php';

include '../../jwt_config.php';

//header("Content-Type: application/json;charset=utf-8;");

$sql = "SELECT * FROM users WHERE username='".$_GET['usr']."'";

//echo $sql;

$result = $mysqli->query($sql);

if($result->num_rows > 0){

	while ($row=$result->fetch_assoc()) {
		// $key = 'n86Iwf9t$xZ9mhNGo54A*FaaaAfUOIZX';
  //       $method = 'aes-256-cbc';
  //       $iv = "B9of31c3b&7*EI0#";
  //       $user_encrypted = base64_encode(openssl_encrypt($row['username'], $method, $key, OPENSSL_RAW_DATA, $iv));
  //       $wallet_encrypted = base64_encode(openssl_encrypt($row['wallet_id'], $method, $key, OPENSSL_RAW_DATA, $iv));

        $url = 'https://www.metahorse.site/users/boxes';

		// Collection object
		$data = array ("quantity"=>$_GET['qty']);

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS,  json_encode($data));
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
		  'Content-Type: application/json',
		  'Authorization: Bearer '.jwttoken($row['username'], $row['wallet_id'])
          //'Authorization: Bearer '.jwttoken('alice', '0x0E1Bfe045d45C365e1E5ccB754eb8199c6d7C9D3')
		]);

		$response = curl_exec($ch);


		// Execute cURL request with all previous settings
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		if($httpcode=='200'){
			http_response_code(200);

			echo 'box purchased';
		}else{
      echo 'box not purchase';
		}
	}

}else{
	//echo 'user not found';
}


//print_r($_SESSION);

?>