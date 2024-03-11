<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Events\ActionEvent;
use App\Http\Controllers\UserController;

class QueryController extends Controller
{
   private $secretKey = "abc123";
   private $apiKey = "oupS3LVmvGeAiCakUjf43Gme2fTAMY8SSORxICrE";
   private $wallet = "";
   private $baseURL = "https://metahorse.ga";

	public function __construct()
	{

	}

	public function swap_g_mbtc(Request $request)
	{
		$user = auth()->user();
		include 'jwt_config.php';

		//new data
		$nud_url = "https://www.metahorse.site/admin/logs/pending";

		$amount = $request->get('amount');

		$current_bal = session()->get('g');

		if($amount<=$current_bal){

			// Convert to MBTC
			$rate = env('MBTC_RATE', 0.008);
			$amount = $amount / $rate;

			$requestParams = [
				"horseId" => null,
				"actionType" => "swap_g_mbtc",
				"value" => $amount,
				"payload" => json_encode(['mbtc_amount' => (string)$amount]),
				"return_Url" => $this->baseURL."/user/dashboard"
			];

			$ch = curl_init($nud_url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, [
				'Content-Type: application/json',
				'Authorization: Bearer '.jwttoken($user->username, $user->wallet_id)
			]);
			curl_setopt($ch, CURLOPT_POST, 1);
	      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestParams));

			$response = curl_exec($ch);
			$actions = json_decode($response);
			curl_close($ch);

			$params = [];
			$params["api_key"] = $actions->api_key;
			$params["user"] = $actions->user;
			$params["request_id"] = $actions->request_id;
			$params["type"] = "swap_g_mbtc";
			$params["payload"] = json_encode(["mbtc_amount" => (string)$amount]);
			$params["to_sign"] = $actions->to_sign;
			$params["return_url"] = $this->baseURL."/user/dashboard";

			$swap_g_mbtc_link = "https://memr3dc-metahorse.0xtechs.com/bridge/onRequest/?".http_build_query($params)."&signature=".$actions->signature;

			return ['success' => true, 'link' => $swap_g_mbtc_link, 'req_param' => $requestParams, 'res_param' => $response];

		}else{
			return ['success' => false, 'message' => 'Insufficient G'];
		}

		
	}
   
	public function swap_mbtc_g(Request $request)
	{
		$user = auth()->user();
		include 'jwt_config.php';

		//new data
		$nud_url = "https://www.metahorse.site/admin/logs/pending";

		$amount = $request->get('amount');

		$requestParams = [
			"horseId" => null,
			"actionType" => "swap_mbtc_g",
			"value" => $amount,
			"payload" => json_encode(['mbtc_amount' => (string)$amount]),
			"return_Url" => $this->baseURL."/user/dashboard"
		];

		$ch = curl_init($nud_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			'Content-Type: application/json',
			'Authorization: Bearer '.jwttoken($user->username, $user->wallet_id)
		]);
		curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestParams));

		$response = curl_exec($ch);
		$actions = json_decode($response);
		curl_close($ch);

		$params = [];
		$params["api_key"] = $actions->api_key;
		$params["user"] = $actions->user;
		$params["request_id"] = $actions->request_id;
		$params["type"] = "swap_mbtc_g";
		$params["payload"] = json_encode(["mbtc_amount" => (string)$amount]);
		$params["to_sign"] = $actions->to_sign;
		$params["return_url"] = $this->baseURL."/user/dashboard";

		$swap_mbtc_g_link = "https://memr3dc-metahorse.0xtechs.com/bridge/onRequest/?".http_build_query($params)."&signature=".$actions->signature;

		return ['success' => true, 'link' => $swap_mbtc_g_link];
	}
   
	public function standard_breed(Request $request)
	{
		$user = auth()->user();
		include 'jwt_config.php';

		// Horse data
		$horseID = $request->get('horse_id');
		$superhorse = $request->get('superhorse');

		$hud_url = "https://www.metahorse.site/users/horses/".$horseID;

		$ch = curl_init($hud_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			'Content-Type: application/json',
			'Authorization: Bearer '.jwttoken($user->username, $user->wallet_id)
		]);

		$hud_response = curl_exec($ch);
		$horse = json_decode($hud_response);

		// Log data
		$nud_url = "https://www.metahorse.site/admin/logs/pending";
		$breedID = $request->get('breed_id');

		$payload = [
			"father_horse" => [
				"id" => $horse->nftAddress,
				"endurance" => (string)$horse->endurance, 
				"speed" => (string)$horse->speed, 
				"stamina" => (string)$horse->stamina, 
				"force" => (string)$horse->force, 
				"temper" => (string)$horse->temper, 
				"adaptability1" => (string)$horse->adaptability1, 
				"adaptability2" => (string)$horse->adaptability2, 
				"grass" => (string)$horse->grass, 
				"muddy" => (string)$horse->muddy
			],
			"mother_horse" => (string)$breedID
		];

		$requestParams = [
			"horseId" => $horse->horseId,
			"actionType" => ($superhorse == '1')? "super_breed" : "standard_breed",
			"value" => 0,
			"payload" => json_encode($payload),
			"return_Url" => $this->baseURL."/user/horses"
		];

		$ch = curl_init($nud_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			'Content-Type: application/json',
			'Authorization: Bearer '.jwttoken($user->username, $user->wallet_id)
		]);
		curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestParams));

		$response = curl_exec($ch);
		$actions = json_decode($response);
		curl_close($ch);

		$params = [];
		$params["api_key"] = $actions->api_key;
		$params["user"] = $actions->user;
		$params["request_id"] = $actions->request_id;
		$params["type"] = ($superhorse == '1')? "super_breed" : "standard_breed";
		$params["payload"] = json_encode($payload);
		$params["to_sign"] = $actions->to_sign;
		$params["return_url"] = $this->baseURL."/user/horses";

		$standard_breed_link = "https://memr3dc-metahorse.0xtechs.com/bridge/onRequest/?".http_build_query($params)."&signature=".$actions->signature;

		return ['success' => true, 'link' => $standard_breed_link];
	}
   
	public function super_breed(Request $request)
	{
		$user = auth()->user();
		include 'jwt_config.php';

		// Horse data
		$horseID = $request->get('horse_id');
		$owner = $request->get('owner');

		if($owner == 1){
			$hud_url = "https://www.metahorse.site/users/horses/".$horseID;
		} else {
			$hud_url = "https://www.metahorse.site/users/superhorses/public/".$horseID;
		}

		$ch = curl_init($hud_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			'Content-Type: application/json',
			'Authorization: Bearer '.jwttoken($user->username, $user->wallet_id)
		]);

		$hud_response = curl_exec($ch);
		$horse = json_decode($hud_response);

		// Log data
		$nud_url = "https://www.metahorse.site/admin/logs/pending";
		$breedID = $request->get('breed_id');

		$payload = [
			"father_horse" => [
				"id" => $horse->nftAddress,
				"endurance" => (string)$horse->endurance, 
				"speed" => (string)$horse->speed, 
				"stamina" => (string)$horse->stamina, 
				"force" => (string)$horse->force, 
				"temper" => (string)$horse->temper, 
				"adaptability1" => (string)$horse->adaptability1, 
				"adaptability2" => (string)$horse->adaptability2, 
				"grass" => (string)$horse->grass, 
				"muddy" => (string)$horse->muddy
			],
			"mother_horse" => (string)$breedID
		];

		$requestParams = [
			"horseId" => $horse->horseId,
			"actionType" => "super_breed",
			"value" => 0,
			"payload" => json_encode($payload),
			"return_Url" => $this->baseURL."/user/horses"
		];

		$ch = curl_init($nud_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			'Content-Type: application/json',
			'Authorization: Bearer '.jwttoken($user->username, $user->wallet_id)
		]);
		curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestParams));

		$response = curl_exec($ch);
		$actions = json_decode($response);
		curl_close($ch);

		$params = [];
		$params["api_key"] = $actions->api_key;
		$params["user"] = $actions->user;
		$params["request_id"] = $actions->request_id;
		$params["type"] = "super_breed";
		$params["payload"] = json_encode($payload);
		$params["to_sign"] = $actions->to_sign;
		$params["return_url"] = $this->baseURL."/user/horses";

		$super_breed_link = "https://memr3dc-metahorse.0xtechs.com/bridge/onRequest/?".http_build_query($params)."&signature=".$actions->signature;

		return ['success' => true, 'link' => $super_breed_link];
	}

	public function update_superhorse(Request $request)
	{
		$user = auth()->user();
		include 'jwt_config.php';

		// Horse data
		$horseID = $request->get('horse_id');
		$superhorse = $request->get('superhorse');

		$hud_url = "https://www.metahorse.site/users/horses/".$horseID;

		$ch = curl_init($hud_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			'Content-Type: application/json',
			'Authorization: Bearer '.jwttoken($user->username, $user->wallet_id)
		]);

		$hud_response = curl_exec($ch);
		$horse = json_decode($hud_response);

		$payload = [
			"father_horse" => [
				"id" => $horse->nftAddress,
				"endurance" => (string)$horse->endurance, 
				"speed" => (string)$horse->speed, 
				"stamina" => (string)$horse->stamina, 
				"force" => (string)$horse->force, 
				"temper" => (string)$horse->temper, 
				"adaptability1" => (string)$horse->adaptability1, 
				"adaptability2" => (string)$horse->adaptability2, 
				"grass" => (string)$horse->grass, 
				"muddy" => (string)$horse->muddy
			],
			"mother_horse" => "1"
		];

		//new data
		$nud_url = "https://www.metahorse.site/admin/logs/pending";

		$requestParams = [
			"horseId" => $horse->horseId,
			"actionType" => "update_superhorse",
			"value" => 0,
			"payload" => json_encode(['horse' => $horse->nftAddress]),
			"return_Url" => $this->baseURL."/user/horse-stat?horse=".$horse->horseId
		];

		$ch = curl_init($nud_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			'Content-Type: application/json',
			'Authorization: Bearer '.jwttoken($user->username, $user->wallet_id)
		]);
		curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestParams));

		$response = curl_exec($ch);
		$actions = json_decode($response);
		curl_close($ch);

		$params = [];
		$params["api_key"] = $actions->api_key;
		$params["user"] = $actions->user;
		$params["request_id"] = $actions->request_id;
		$params["type"] = "update_superhorse";
		//$params["payload"] = json_encode(["horse" => $horse->nftAddress]);
		$params["payload"] = json_encode($payload);
		$params["to_sign"] = $actions->to_sign;
		$params["return_url"] = $this->baseURL."/user/horse-stat?horse=".$horse->horseId;

		$update_superhorse_link = "https://memr3dc-metahorse.0xtechs.com/bridge/onRequest/?".http_build_query($params)."&signature=".$actions->signature;

		return ['success' => true, 'link' => $update_superhorse_link];
	}

}
