<?php

namespace App\Http\Controllers;

use App\Lib\GoogleAuthenticator;
use App\Models\AdminNotification;
use App\Models\Bet;
use App\Models\CommissionLog;
use App\Models\GeneralSetting;
use App\Models\SupportTicket;
use App\Models\Transaction;
use App\Models\User;
use App\Models\WithdrawMethod;
use App\Models\Withdrawal;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function __construct()
    {
        $this->activeTemplate = activeTemplate();
    }

    public function home()
    {
        
        
        
        $pageTitle                  = 'Dashboard';
        $user                       = auth()->user();
        $widget['totalTransaction'] = Transaction::where('user_id', $user->id)->count();
        $widget['totalBet']         = Bet::where('user_id', $user->id)->count();
        $widget['totalPending']     = Bet::where('user_id', $user->id)->where('status', 0)->count();
        $widget['totalWin']         = Bet::where('user_id', $user->id)->where('status', 1)->count();
        $widget['totalLose']        = Bet::where('user_id', $user->id)->where('status', 2)->count();
        $widget['totalRefund']      = Bet::where('user_id', $user->id)->where('status', 3)->count();
        $widget['totalTicket']      = SupportTicket::where('user_id', $user->id)->count();
        $bets                       = Bet::where('user_id', auth()->user()->id)->latest()->limit(15)->with(['match','question','option'])->get();
        
        $url = 'https://deep-index.moralis.io/api/v2/'.$user->wallet_id.'/balance?chain=bsc%20testnet&providerUrl=https%3A%2F%2Fdata-seed-prebsc-1-s1.binance.org%3A8545%2F';
        
        // Initializes a new cURL session
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
		  'Content-Type: application/json',
		  'X-API-Key: 02ROjW2RnhAy6Wy7FpKgOtMDlozYlkkqDb6F7aEkWrBbKgTzwGdT9PjvgZeqFmUz'
		]);

		$response = curl_exec($ch);


		// Execute cURL request with all previous settings
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		
		$wbalance=json_decode($response,1);
		
		$widget['walletBal']         = number_format($wbalance['balance']/1000000000000000000,4);

        session(['walbal' => $widget['walletBal']]);
		
		//Get user game data
		
		include 'jwt_config.php';
		
		$ud_url="https://www.metahorse.site/users";
		
		$ch = curl_init($ud_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
		  'Content-Type: application/json',
		  'Authorization: Bearer '.jwttoken($user->username, $user->wallet_id)
          // 'Authorization: Bearer '.jwttoken('XinYi', '0x701aC5396658C98063f2CCE0501a6747DfaE4360')
		]);

        session(['jwt' => jwttoken($user->username, $user->wallet_id)]);
		
		$ud_response = curl_exec($ch);
		
		$widget['UGData']         = $ud_response;
		
		$UData = json_decode($ud_response);

        $widget['GBalance']= $UData->g;
        session(['g' => $widget['GBalance']]);
		
		
		//$_SESSION['G']=$widget['GBalance'];
		
		$gdata['horses'] = (array) $UData->horses;
		
		$gdata['items'] = (array) $UData->items;
		
        

        session(['user' => $user->username]);

        $widget['GBalance2'] = session('g', $widget['GBalance']);

        
        $sm_url="https://www.metahorse.site/users/summary";
        
        $ch = curl_init($sm_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.jwttoken($user->username, $user->wallet_id)
          // 'Authorization: Bearer '.jwttoken('alice', '0x0E1Bfe045d45C365e1E5ccB754eb8199c6d7C9D3')
        ]);
        
        $sm_response = curl_exec($ch);

        $widget['Summary']         = json_decode($sm_response,1);


        //wallet

        $enc_data=array('username'=>$user->username,'wallet'=>$user->wallet_id);

        //$enc_data=array('MayaKyle','0x6A91f0D3c462987a03Fa15E457BF5295f8156c1F');

        $enc=encryptString($enc_data);

        $sm_url="http://www.metahorse.site/users/g?t=".$enc;
        
        $ch = curl_init($sm_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.jwttoken($user->username, $user->wallet_id)
          // 'Authorization: Bearer '.jwttoken('alice', '0x0E1Bfe045d45C365e1E5ccB754eb8199c6d7C9D3')
        ]);
        
        $sm_response = curl_exec($ch);

        $widget['Wallet']         = json_decode($sm_response,1);
		
        
        return view($this->activeTemplate . 'user.dashboard', compact('pageTitle', 'user', 'widget', 'bets', 'gdata'));
    }

    public function userwallet()
    {

        $user = auth()->user();
        
        include 'jwt_config.php';

        $enc_data=array('username'=>$user->username,'wallet'=>$user->wallet_id);

        //$enc_data=array('MayaKyle','0x6A91f0D3c462987a03Fa15E457BF5295f8156c1F');

        $enc=encryptString($enc_data);

        $ud_url="https://www.metahorse.site/users/g?t=".urlencode($enc);
        
        $ch = curl_init($ud_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json'
        ]);

        
        $ud_response = curl_exec($ch);

        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $g= json_decode($ud_response,1);

        $walbal = $g['g'];

        session('g', $walbal);
        
        return view($this->activeTemplate . 'user.gwallet', compact('user','ud_response','walbal'));
    }

    public function rewardClaim(Request $request)
    {

        $user = auth()->user();

        include 'jwt_config.php';
        
        //new data

        $nud_url="https://www.metahorse.site/users/rewards/claim";

        $ch = curl_init($nud_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.jwttoken($user->username, $user->wallet_id)
          // 'Authorization: Bearer '.jwttoken('alice', '0x0E1Bfe045d45C365e1E5ccB754eb8199c6d7C9D3')
        ]);

        
        $response = curl_exec($ch);


        // Execute cURL request with all previous settings
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if($httpcode=='200'){

            $notify[] = ['success', '@lang("Claimed successfully!")'];
            return back()->withNotify($notify);
            
        }else{

            $notify[] = ['error', '@lang("Failed to claim!")'];
            return back()->withNotify($notify);
        }

    }

    public function horseRent(Request $request)
    {

        $user = auth()->user();

        include 'jwt_config.php';
        
        //new data

        $url = 'https://www.metahorse.site/users/superhorses/'.$request->hid.'/rent';

        // Collection object
        $data = array ("horseId"=>$request->hid);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS,  json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.jwttoken($user->username, $user->wallet_id)
          // 'Authorization: Bearer '.jwttoken('alice', '0x0E1Bfe045d45C365e1E5ccB754eb8199c6d7C9D3')
        ]);

        
        $response = curl_exec($ch);


        // Execute cURL request with all previous settings
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if($httpcode=='200'){

            $notify[] = ['success', '@lang("horse rented successfully!")'];
            return back()->withNotify($notify);
            
        }else{

            $notify[] = ['error', '@lang("Horse failed to rent!")'];
            return back()->withNotify($notify);
        }

    }

    public function horses()
    {

        $pageTitle                  = 'My Horses';
        $user                       = auth()->user();
        
        include 'jwt_config.php';
        
        $ud_url="https://www.metahorse.site/users";
        
        $ch = curl_init($ud_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.jwttoken($user->username, $user->wallet_id)
        ]);

        session(['jwt' => jwttoken($user->username, $user->wallet_id)]);
        
        $ud_response = curl_exec($ch);
        
        $widget['UGData']         = $ud_response;
        
        $UData = json_decode($ud_response);
        
        
        //$_SESSION['G']=$widget['GBalance'];
        
        $gdata['horses'] = (array) $UData->horses;
        
        return view($this->activeTemplate . 'user.horses', compact('pageTitle', 'user', 'widget', 'gdata'));
    }

    public function verifyHorse(Request $request)
    {

        $user = auth()->user();

        include 'jwt_config.php';
        
        //new data

        $hud_url="https://www.metahorse.site/users/horses/".$request->hid;
        
        $ch = curl_init($hud_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.jwttoken($user->username, $user->wallet_id)
          // 'Authorization: Bearer '.jwttoken('alice', '0x0E1Bfe045d45C365e1E5ccB754eb8199c6d7C9D3')
        ]);
        
        $hud_response = curl_exec($ch);

        $h_details = json_decode($hud_response);


        if(isset($h_details->horseId)){

            return redirect('user/horse-stat?horse='.$h_details->horseId);

        }else{

            $message = $h_details->messages;

            $notify[] = ['error', $message[0]];
            return back()->withNotify($notify);

        }

    }

    public function horseStats()
    {

        $pageTitle                  = 'Horse Stats';
        $user                       = auth()->user();
        
        //Get user game data
        
        include 'jwt_config.php';
        
        //new data

        $hud_url="https://www.metahorse.site/users/horses/".$_GET['horse'];
        
        $ch = curl_init($hud_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.jwttoken($user->username, $user->wallet_id)
          // 'Authorization: Bearer '.jwttoken('alice', '0x0E1Bfe045d45C365e1E5ccB754eb8199c6d7C9D3')
        ]);
        
        $hud_response = curl_exec($ch);

        $gdata['horses_new'] = json_decode($hud_response);
        
        
        return view($this->activeTemplate . 'user.horsestat', compact('pageTitle', 'user', 'gdata'));
    }

    public function verifyBreed(Request $request)
    {

        $user = auth()->user();

        include 'jwt_config.php';
        
        //new data

        $hud_url='https://www.metahorse.site/users/horses/'.$request->hid.'/validate';
        
        $ch = curl_init($hud_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.jwttoken($user->username, $user->wallet_id)
          // 'Authorization: Bearer '.jwttoken('alice', '0x0E1Bfe045d45C365e1E5ccB754eb8199c6d7C9D3')
        ]);
        
        $hud_response = curl_exec($ch);

        $h_details = json_decode($hud_response);

        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);


        if($httpcode=='200'){

            $notify[] = ['success', '@lang("Breed Verified!")'];

            if($request->type=='Super'){
                return redirect('user/superhorse-breed?horse='.$request->hid.'&o='.$request->o)->withNotify($notify);
            }else{
                return redirect('user/breed?horse='.$request->hid)->withNotify($notify);
            }

        }else{

            $message = $h_details->messages;

            $notify[] = ['error', $message[0]];
            return back()->withNotify($notify);

        }

    }

    public function horseTrain()
    {

        $pageTitle                  = 'Horse Train';
        $user                       = auth()->user();
        
        //Get user game data
        
        include 'jwt_config.php';
        
        $ud_url="https://www.metahorse.site/users";
        
        $ch = curl_init($ud_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.jwttoken($user->username, $user->wallet_id)
          // 'Authorization: Bearer '.jwttoken('alice', '0x0E1Bfe045d45C365e1E5ccB754eb8199c6d7C9D3')
        ]);

        session(['jwt' => jwttoken($user->username, $user->wallet_id)]);
        
        $ud_response = curl_exec($ch);
        
        $widget['UGData']         = $ud_response;
        
        $UData = json_decode($ud_response);
        
        
        //$_SESSION['G']=$widget['GBalance'];
        
        $gdata['horses'] = (array) $UData->horses;
        
        

        session(['user' => $user->username]);


        $enc_data=array('username'=>$user->username,'wallet'=>$user->wallet_id);

        //$enc_data=array('MayaKyle','0x6A91f0D3c462987a03Fa15E457BF5295f8156c1F');

        $enc=encryptString($enc_data);

        $gdata['back_link'] = $_SERVER['HTTP_REFERER'];

        $gdata['iframe_link']='https://webgltest-mh.s3.amazonaws.com/Main/TrainingCentreWebGL/index.html?t='.$enc;
        
        
        return view($this->activeTemplate . 'user.horsetrain', compact('pageTitle', 'user', 'widget', 'gdata', 'enc_data'));
    }


    public function profile()
    {
        $pageTitle = "Account Settings";
        $user = Auth::user();
        return view($this->activeTemplate. 'user.profile_setting', compact('pageTitle','user'));
    }

    public function horseBreed()
    {
        $pageTitle = "Breed";
        $user                       = auth()->user();
        
        //Get user game data
        
        include 'jwt_config.php';
        
        $ud_url="https://www.metahorse.site/users";
        
        $ch = curl_init($ud_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.jwttoken($user->username, $user->wallet_id)
          // 'Authorization: Bearer '.jwttoken('alice', '0x0E1Bfe045d45C365e1E5ccB754eb8199c6d7C9D3')
        ]);

        session(['jwt' => jwttoken($user->username, $user->wallet_id)]);
        
        $ud_response = curl_exec($ch);
        
        $widget['UGData']         = $ud_response;
        
        $UData = json_decode($ud_response);
        
        
        //$_SESSION['G']=$widget['GBalance'];
        
        $gdata['horses'] = (array) $UData->horses;
        
        return view($this->activeTemplate. 'user.breed', compact('pageTitle','user', 'gdata'));
    }

    public function superHorseBreed()
    {
        $pageTitle = "Super Breed";
        $user                       = auth()->user();
        
        //Get user game data
        
        include 'jwt_config.php';
        
        $ud_url="https://www.metahorse.site/users/superhorses/public/".$_GET['horse'];

        if($_GET['o']==1){
            $ud_url="https://www.metahorse.site/users/horses/".$_GET['horse'];
        }
        
        $ch = curl_init($ud_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.jwttoken($user->username, $user->wallet_id)
          // 'Authorization: Bearer '.jwttoken('alice', '0x0E1Bfe045d45C365e1E5ccB754eb8199c6d7C9D3')
        ]);

        session(['jwt' => jwttoken($user->username, $user->wallet_id)]);
        
        $ud_response = curl_exec($ch);
        
        $widget['UGData']         = $ud_response;
        
        $gdata['horses'] = json_decode($ud_response);
        
        
        //$_SESSION['G']=$widget['GBalance'];
        
        //$gdata['horses'] = (array) $UData;
        
        return view($this->activeTemplate. 'user.shbreed', compact('pageTitle','user', 'gdata'));
    }


    public function superBreed()
    {

        $pageTitle                  = 'Super Breed';
        $user                       = auth()->user();
        
        include 'jwt_config.php';
        
        $ud_url="https://www.metahorse.site/users/superhorses/public";
        
        $ch = curl_init($ud_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.jwttoken($user->username, $user->wallet_id)
          // 'Authorization: Bearer '.jwttoken('alice', '0x0E1Bfe045d45C365e1E5ccB754eb8199c6d7C9D3')
        ]);

        session(['jwt' => jwttoken($user->username, $user->wallet_id)]);
        
        $ud_response = curl_exec($ch);
        
        $widget['UGData']         = $ud_response;
        
        $UData = json_decode($ud_response);
        
        
        //$_SESSION['G']=$widget['GBalance'];
        
        $gdata['super_horses'] = (array) $UData;
        
        

        
        
        return view($this->activeTemplate . 'user.super_horses', compact('pageTitle', 'user', 'widget', 'gdata'));
    }

    public function shBreedVerify()
    {
        $pageTitle = "Breed Super Horse";
        $user                       = auth()->user();
        
        
        
        include 'jwt_config.php';
        
        $ud_url="https://www.metahorse.site/users/superhorses/public";

        if($_POST['o']==1){
            $ud_url="https://www.metahorse.site/users/horses/".$_POST['horse'];
        }
        
        $ch = curl_init($ud_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.jwttoken($user->username, $user->wallet_id)
          // 'Authorization: Bearer '.jwttoken('alice', '0x0E1Bfe045d45C365e1E5ccB754eb8199c6d7C9D3')
        ]);

        session(['jwt' => jwttoken($user->username, $user->wallet_id)]);
        
        $ud_response = curl_exec($ch);
        
        $widget['UGData']         = $ud_response;
        
        $UData = json_decode($ud_response);
        
        
        //$_SESSION['G']=$widget['GBalance'];
        
        $gdata['horses'] = (array) $UData;
        
        return view($this->activeTemplate. 'user.shbreed_verify', compact('pageTitle','user', 'widget', 'gdata'));
    }

    public function shStats()
    {

        $pageTitle                  = 'Super Horse Stats';
        $user                       = auth()->user();
        
        //Get user game data
        
        include 'jwt_config.php';
        
        //new data

        $hud_url="https://www.metahorse.site/users/superhorses/public/".$_GET['horse'];
        
        $ch = curl_init($hud_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.jwttoken($user->username, $user->wallet_id)
          // 'Authorization: Bearer '.jwttoken('alice', '0x0E1Bfe045d45C365e1E5ccB754eb8199c6d7C9D3')
        ]);
        
        $hud_response = curl_exec($ch);

        $gdata['horses_new'] = json_decode($hud_response);
        
        
        return view($this->activeTemplate . 'user.shstat', compact('pageTitle', 'user', 'gdata'));
    }


    public function nftVerify()
    {
        $pageTitle = "Breed Horse";
        $user                       = auth()->user();
        
        
        
        include 'jwt_config.php';
        
        $ud_url="https://www.metahorse.site/users";
        
        $ch = curl_init($ud_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.jwttoken($user->username, $user->wallet_id)
          // 'Authorization: Bearer '.jwttoken('alice', '0x0E1Bfe045d45C365e1E5ccB754eb8199c6d7C9D3')
        ]);

        session(['jwt' => jwttoken($user->username, $user->wallet_id)]);
        
        $ud_response = curl_exec($ch);
        
        $widget['UGData']         = $ud_response;
        
        $UData = json_decode($ud_response);
        
        
        //$_SESSION['G']=$widget['GBalance'];
        
        $gdata['horses'] = (array) $UData->horses;
        
        return view($this->activeTemplate. 'user.nft_verify', compact('pageTitle','user', 'widget', 'gdata'));
    }


    //items

    public function items()
    {

        $pageTitle                  = 'My Items';
        $user                       = auth()->user();
        
        //Get user game data
        
        include 'jwt_config.php';
        
        $ud_url="https://www.metahorse.site/users";
        
        $ch = curl_init($ud_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.jwttoken($user->username, $user->wallet_id)
          // 'Authorization: Bearer '.jwttoken('alice', '0x0E1Bfe045d45C365e1E5ccB754eb8199c6d7C9D3')
        ]);

        session(['jwt' => jwttoken($user->username, $user->wallet_id)]);
        
        $ud_response = curl_exec($ch);
        
        $widget['UGData']         = $ud_response;

        $UData = json_decode($ud_response);
        
        $gdata['items'] = (array) $UData->items;
        
        
        return view($this->activeTemplate . 'user.items', compact('pageTitle', 'user', 'widget', 'gdata'));
    }

    public function verifyItem(Request $request)
    {

        $user = auth()->user();

        include 'jwt_config.php';
        
        //new data

        $nud_url="https://www.metahorse.site/users/items/".$request->iid;

        $ch = curl_init($nud_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.jwttoken($user->username, $user->wallet_id)
          // 'Authorization: Bearer '.jwttoken('alice', '0x0E1Bfe045d45C365e1E5ccB754eb8199c6d7C9D3')
        ]);

        
        $nud_response = curl_exec($ch);

        $item = json_decode($nud_response);


        if(isset($item->itemUniqueId)){

            return redirect('user/item-stat?item='.$item->itemUniqueId);

        }else{

            $message = $item->messages;

            $notify[] = ['error', $message[0]];
            return back()->withNotify($notify);

        }

    }

    public function item_stats()
    {

        $pageTitle                  = 'Item Stats';
        $user                       = auth()->user();
        
        //Get user game data
        
        include 'jwt_config.php';
        
        $nud_url="https://www.metahorse.site/users/items/".$_GET['item'];

        $ch = curl_init($nud_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.jwttoken($user->username, $user->wallet_id)
          // 'Authorization: Bearer '.jwttoken('alice', '0x0E1Bfe045d45C365e1E5ccB754eb8199c6d7C9D3')
        ]);

        
        $nud_response = curl_exec($ch);


       $nUData = json_decode($nud_response);
        
        $gdata['items_new'] = $nUData;
        
        return view($this->activeTemplate . 'user.itemstat', compact('pageTitle', 'user', 'gdata'));
    }

    public function canteen()
    {

        $pageTitle                  = 'Canteen';
        $user                       = auth()->user();
        
        //Get user game data
        
        include 'jwt_config.php';
        
        $ud_url="https://www.metahorse.site/users";
        
        $ch = curl_init($ud_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.jwttoken($user->username, $user->wallet_id)
          // 'Authorization: Bearer '.jwttoken('alice', '0x0E1Bfe045d45C365e1E5ccB754eb8199c6d7C9D3')
        ]);

        session(['jwt' => jwttoken($user->username, $user->wallet_id)]);
        
        $ud_response = curl_exec($ch);
        
        $widget['UGData']         = $ud_response;
        
        $UData = json_decode($ud_response);
        
        $gdata['items'] = (array) $UData->items;

        $enc_data=array('username'=>$user->username,'wallet'=>$user->wallet_id);

        //$enc_data=array('MayaKyle','0x6A91f0D3c462987a03Fa15E457BF5295f8156c1F');

        $enc=encryptString($enc_data);

        $gdata['iframe_link']='https://webgltest-mh.s3.amazonaws.com/Main/CanteenWebGL/index.html?t='.$enc;

        $gdata['back_link'] = $_SERVER['HTTP_REFERER'];        
        
        return view($this->activeTemplate . 'user.canteen', compact('pageTitle', 'user', 'widget', 'gdata'));
    }

    public function boxes()
    {

        $pageTitle                  = 'Mystery Box';
        $user                       = auth()->user();        
        
        return view($this->activeTemplate . 'user.boxes', compact('pageTitle', 'user'));
    }

    public function boxesDraw()
    {

        $pageTitle                  = 'Draw Box';
        $user                       = auth()->user();

        include 'jwt_config.php';

        $enc_data=array('username'=>$user->username,'wallet'=>$user->wallet_id);

        //$enc_data=array('MayaKyle','0x6A91f0D3c462987a03Fa15E457BF5295f8156c1F');

        $enc=encryptString($enc_data);

        $gdata['iframe_link']='https://webgltest-mh.s3.amazonaws.com/Main/MysteryBoxWebGL/index.html?t='.$enc;
        
        return view($this->activeTemplate . 'user.draw_box', compact('pageTitle', 'user', 'gdata'));
    }

    public function boxesPurchase()
    {

        $pageTitle                  = 'Purchase Box';
        $user                       = auth()->user();
        
        include 'jwt_config.php';
        
        $ud_url="https://www.metahorse.site/users";
        
        $ch = curl_init($ud_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.jwttoken($user->username, $user->wallet_id)
          // 'Authorization: Bearer '.jwttoken('alice', '0x0E1Bfe045d45C365e1E5ccB754eb8199c6d7C9D3')
        ]);

        
        $ud_response = curl_exec($ch);
        
        $widget['UGData']         = $ud_response;
        
        $UData = json_decode($ud_response);

        $widget['GBalance']= $UData->g;
                
        
        return view($this->activeTemplate . 'user.purchase_box', compact('pageTitle', 'user', 'widget'));
    }

    public function submitPurchase(Request $request)
    {

        $user                       = auth()->user();
        
        include 'jwt_config.php';
        
        $url = 'https://www.metahorse.site/users/boxes';

        // Collection object
        $data = array ("quantity"=>$request->quantity);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS,  json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.jwttoken($user->username, $user->wallet_id)
          // 'Authorization: Bearer '.jwttoken('alice', '0x0E1Bfe045d45C365e1E5ccB754eb8199c6d7C9D3')
        ]);

        
        $ud_response = curl_exec($ch);

        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if($httpcode=='200'){

            $notify[] = ['success', '@lang("Box Purchased!")'];
            return redirect('user/draw-box')->withNotify($notify);

        }else{

            $notify[] = ['error', '@lang("Box Not Purchased!")'.$ud_response];
            return back()->withNotify($notify);

        }
                
        
    }


    public function gameRewards()
    {

        $pageTitle                  = 'Game Rewards';
        $user                       = auth()->user();
        
        include 'jwt_config.php';
        
        $ud_url="https://www.metahorse.site/users/rewards/all";
        
        $ch = curl_init($ud_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.jwttoken($user->username, $user->wallet_id)
          // 'Authorization: Bearer '.jwttoken('alice', '0x0E1Bfe045d45C365e1E5ccB754eb8199c6d7C9D3')
        ]);

        
        $ud_response = curl_exec($ch);
        
        $widget['UGData']         = $ud_response;
        
        $widget['Rewards'] = json_decode($ud_response,1);
                
        
        return view($this->activeTemplate . 'user.game_rewards', compact('pageTitle', 'user', 'widget'));
    }

    public function gameDeposit()
    {

        $pageTitle                  = 'Game Deposit';
        $user                       = auth()->user();
        
        include 'jwt_config.php';
        
        $ud_url="https://www.metahorse.site/users/logs/deposit/all";
        
        $ch = curl_init($ud_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.jwttoken($user->username, $user->wallet_id)
          // 'Authorization: Bearer '.jwttoken('alice', '0x0E1Bfe045d45C365e1E5ccB754eb8199c6d7C9D3')
        ]);

        
        $ud_response = curl_exec($ch);
        
        $widget['UGData']         = $ud_response;
        
        $widget['Deposits'] = (array) json_decode($ud_response);

        return view($this->activeTemplate . 'user.game_deposit', compact('pageTitle', 'user', 'widget'));
    }

    public function gameWithdrawal()
    {

        $pageTitle                  = 'Game Withdrawal';
        $user                       = auth()->user();
        
        include 'jwt_config.php';
        
        $ud_url="https://www.metahorse.site/users/logs/withdrawal/all";
        
        $ch = curl_init($ud_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.jwttoken($user->username, $user->wallet_id)
          // 'Authorization: Bearer '.jwttoken('alice', '0x0E1Bfe045d45C365e1E5ccB754eb8199c6d7C9D3')
        ]);

        
        $ud_response = curl_exec($ch);
        
        $widget['UGData']         = $ud_response;
        
        $widget['Withdrawals']= (array) json_decode($ud_response);

        return view($this->activeTemplate . 'user.game_withdrawal', compact('pageTitle', 'user', 'widget'));
    }


    public function verifySuperHorse(Request $request)
    {

        $user = auth()->user();

        include 'jwt_config.php';
        
        //new data

        $hud_url="https://www.metahorse.site/users/superhorses/public/".$request->hid;
        
        $ch = curl_init($hud_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.jwttoken($user->username, $user->wallet_id)
          // 'Authorization: Bearer '.jwttoken('alice', '0x0E1Bfe045d45C365e1E5ccB754eb8199c6d7C9D3')
        ]);
        
        $hud_response = curl_exec($ch);

        $h_details = json_decode($hud_response);


        if(isset($h_details->horseId)){

            return redirect('user/superhorse-stat?horse='.$h_details->horseId);

        }else{

            $message = $h_details->messages;

            $notify[] = ['error', $message[0]];
            return back()->withNotify($notify);

        }

    }


    //match

    public function joinMatch()
    {

        $pageTitle                  = 'MY MATCHES';
        $user                       = auth()->user();
                
        $gdata['listed_match'] =(object) array(
            array(
                'stadiumName'=>'Japan',
                'stadiumDistance'=>'1400m',
                'routeType'=>'Grass',
                'betStartDate'=>'1662437100',
                'betEndDate'=>'1662440700'
            ),
            array(
                'stadiumName'=>'Japan',
                'stadiumDistance'=>'1400m',
                'routeType'=>'Grass',
                'betStartDate'=>'1662437100',
                'betEndDate'=>'1662440700'
            ),
            array(
                'stadiumName'=>'Japan',
                'stadiumDistance'=>'1400m',
                'routeType'=>'Grass',
                'betStartDate'=>'1662437100',
                'betEndDate'=>'1662440700'
            ),
            array(
                'stadiumName'=>'Japan',
                'stadiumDistance'=>'1400m',
                'routeType'=>'Grass',
                'betStartDate'=>'1662437100',
                'betEndDate'=>'1662440700'
            ),
            array(
                'stadiumName'=>'Japan',
                'stadiumDistance'=>'1400m',
                'routeType'=>'Grass',
                'betStartDate'=>'1662550217',
                'betEndDate'=>'1662635417'
            ),
            array(
                'stadiumName'=>'Japan',
                'stadiumDistance'=>'1400m',
                'routeType'=>'Grass',
                'betStartDate'=>'1662635417',
                'betEndDate'=>'1662721817'
            )
        );

        include 'jwt_config.php';
        
        $ud_url="https://www.metahorse.site/matches/users/daily";
        
        $ch = curl_init($ud_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.jwttoken($user->username, $user->wallet_id)
          // 'Authorization: Bearer '.jwttoken('alice', '0x0E1Bfe045d45C365e1E5ccB754eb8199c6d7C9D3')
        ]);

        
        $ud_response = curl_exec($ch);
        
        $gdata['UGData']         = $ud_response;
        
        $gdata['daily_match']= (array) json_decode($ud_response);

        foreach ($gdata['daily_match'] as $key => $value) {
            
            $re_url="https://www.metahorse.site/matches/".$value->matchId."/results";
        
            $ch = curl_init($re_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
              'Content-Type: application/json',
              'Authorization: Bearer '.jwttoken($user->username, $user->wallet_id)
              // 'Authorization: Bearer '.jwttoken('alice', '0x0E1Bfe045d45C365e1E5ccB754eb8199c6d7C9D3')
            ]);

            
            $re_response = curl_exec($ch);

            $gdata['match_results'][]=(array) json_decode($re_response);

            $enc_data=array('username'=>$user->username,'wallet'=>$user->wallet_id);

            //$enc_data=array('MayaKyle','0x6A91f0D3c462987a03Fa15E457BF5295f8156c1F');

            $enc=encryptString($enc_data);

            switch ($value->stadiumName) {
                case 'Japan':
                    $gdata['match_replay'][]='https://webgltest-mh.s3.amazonaws.com/Main/StadiumJPPlaybackWebGL/index.html?m='.$value->matchId.'&t='.$enc;
                    break;

                case 'United Kingdom':
                    $gdata['match_replay'][]='https://webgltest-mh.s3.amazonaws.com/Main/StadiumUKPlaybackWebGL/index.html?m='.$value->matchId.'&t='.$enc;
                    break;

                case 'France':
                    $gdata['match_replay'][]='https://webgltest-mh.s3.amazonaws.com/Main/StadiumFRPlaybackWebGL/index.html?m='.$value->matchId.'&t='.$enc;
                    break;

                case 'United States':
                    $gdata['match_replay'][]='https://webgltest-mh.s3.amazonaws.com/Main/StadiumUSAPlaybackWebGL/index.html?m='.$value->matchId.'&t='.$enc;
                    break;

                case 'UAE':
                    $gdata['match_replay'][]='https://webgltest-mh.s3.amazonaws.com/Main/StadiumUAEPlaybackWebGL/index.html?m='.$value->matchId.'&t='.$enc;
                    break;
            }

        }
        
        return view($this->activeTemplate . 'user.join_match', compact('pageTitle', 'user', 'gdata'));
    }

    public function verifyMatch(Request $request)
    {

        $user = auth()->user();

        include 'jwt_config.php';
        
        //new data

        $hud_url="https://www.metahorse.site/matches/rankingraced1/flag";
        
        $ch = curl_init($hud_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.jwttoken($user->username, $user->wallet_id)
          // 'Authorization: Bearer '.jwttoken('alice', '0x0E1Bfe045d45C365e1E5ccB754eb8199c6d7C9D3')
        ]);
        
        $hud_response = curl_exec($ch);

        if($hud_response=='true'){
            $notify[] = ['success', '@lang("Verified!")'];
            return redirect('user/match-registraion')->withNotify($notify);
        }else{
            $notify[] = ['error', '@lang("OSAKA CHAMPIONSHIP WORLD CUP OPENS REGISTRATION ON THURSDAY ONLY")'];
            return back()->withNotify($notify);
        }

    }

    public function matchHorseVerify(Request $request)
    {

        $user = auth()->user();

        include 'jwt_config.php';
        
        //new data

        $hud_url="https://www.metahorse.site/matches/rankingraced1/validate/".$request->horse;
        
        $ch = curl_init($hud_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.jwttoken($user->username, $user->wallet_id)
          // 'Authorization: Bearer '.jwttoken('alice', '0x0E1Bfe045d45C365e1E5ccB754eb8199c6d7C9D3')
        ]);
        
        $hud_response = curl_exec($ch);

        if($hud_response=='true'){

            $rehud_url="https://www.metahorse.site/matches/rankingraced1/join/".$request->horse;
        
            $ch = curl_init($rehud_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
              'Content-Type: application/json',
              'Authorization: Bearer '.jwttoken($user->username, $user->wallet_id)
              // 'Authorization: Bearer '.jwttoken('alice', '0x0E1Bfe045d45C365e1E5ccB754eb8199c6d7C9D3')
            ]);
            
            $rehud_response = curl_exec($ch);

            $notify[] = ['success', '@lang("Registered")'];
            return back()->withNotify($notify);

        }else{
            $notify[] = ['error', '@lang("SELECTED HORSE IS NOT ELIGIBLE TO JOIN. PLEASE CHECK ITS TIRENESS AND MINIMUM WEEKLY BETS MUST BE REACHED.")'];
            return back()->withNotify($notify);
        }

    }

    public function matchResults()
    {

        $pageTitle                  = 'Results';
        $user                       = auth()->user();

        include 'jwt_config.php';
        
        $ud_url="https://www.metahorse.site/matches/past";
        
        $ch = curl_init($ud_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.jwttoken($user->username, $user->wallet_id)
          // 'Authorization: Bearer '.jwttoken('alice', '0x0E1Bfe045d45C365e1E5ccB754eb8199c6d7C9D3')
        ]);

        
        $ud_response = curl_exec($ch);
        
        $gdata['UGData']         = $ud_response;
        
        $gdata['past_match']= (array) json_decode($ud_response);
                
        
        return view($this->activeTemplate . 'user.match_results', compact('pageTitle', 'user', 'gdata'));
    }


    public function listResults()
    {

        $user = auth()->user();

        if($_GET['res']>0){
            include 'jwt_config.php';
            
            $re_url="https://www.metahorse.site/matches/".$_GET['mid']."/results";
            
            $ch = curl_init($re_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
              'Content-Type: application/json',
              'Authorization: Bearer '.jwttoken($user->username, $user->wallet_id)
              // 'Authorization: Bearer '.jwttoken('alice', '0x0E1Bfe045d45C365e1E5ccB754eb8199c6d7C9D3')
            ]);

                
            $re_response = curl_exec($ch);

            $l_horse=(array) json_decode($re_response);

            echo '

            <h5>'.$l_horse['stadium']->stadiumName.' ('.$l_horse['stadium']->stadiumDistance.'M)</h5>
            <p class="my-3 text-white">'.$l_horse['stadium']->routeType.'</p>


            <div class="table-responsive mt-2">
                <table class="table table-dark text-center w-md-100">
                  <thead>
                    <th scope="col">Rank</th>
                    <th scope="col">Horse Name</th>
                    <th scope="col">Horse No.</th>
                    <th scope="col">Owner</th>
                  </thead>
                  <tbody>
            ';

            if(count($l_horse['horses'])>0){

                $trophy='';

                foreach ($l_horse['horses'] as $h_data) {

                    switch ($h_data->playerRanking) {
                        case '1':
                            $trophy='<img src="'.getImage(imagePath()['logoIcon']['path'] .'/TrophyGold.png').'" class="trophy-icon">';
                            break;

                        case '2':
                            $trophy='<img src="'.getImage(imagePath()['logoIcon']['path'] .'/TrophySilver.png').'" class="trophy-icon">';
                            break;

                        case '3':
                            $trophy='<img src="'.getImage(imagePath()['logoIcon']['path'] .'/TrophyBronze.png').'" class="trophy-icon">';
                            break;

                        default:
                            $trophy='';
                            break;

                        
                    }


                    echo '

                    <tr>
                      <td>'.$trophy.' #'.$h_data->playerRanking.'</td>
                      <td>'.$h_data->horseName.'</td>
                      <td>'.$h_data->horseNumber.'</td>
                      <td>'.$h_data->username.'</td>
                    </tr>

                    ';
                }

            }else{
                echo '<td colspan="4"></td>';
            }


            echo'
                        </tbody>
                    </table>
                </div>


            ';
        }else{
            echo '<h5 class="mb-5">RESULT IS PROCESSING. PLEASE TRY AGAIN LATER.</h5>';
        }
                
        
        return;
    }

    public function listReplay()
    {

        $user = auth()->user();

        if($_GET['res']>0){
            include 'jwt_config.php';
            
            $enc_data=array('username'=>$user->username,'wallet'=>$user->wallet_id);

                //$enc_data=array('MayaKyle','0x6A91f0D3c462987a03Fa15E457BF5295f8156c1F');

                $enc=encryptString($enc_data);

                switch (trim($_GET['sname']," ")) {
                    case 'Japan':
                        echo '<iframe class="embed-responsive-item" src="https://webgltest-mh.s3.amazonaws.com/Main/StadiumJPPlaybackWebGL/index.html?m='.$_GET['mid'].'&t='.$enc.'" id="iFrame1"></iframe>';
                        break;

                    case 'United Kingdom':
                        echo '<iframe class="embed-responsive-item" src="https://webgltest-mh.s3.amazonaws.com/Main/StadiumUKPlaybackWebGL/index.html?m='.$_GET['mid'].'&t='.$enc.'" id="iFrame1"></iframe>';
                        break;

                    case 'France':
                        echo '<iframe class="embed-responsive-item" src="https://webgltest-mh.s3.amazonaws.com/Main/StadiumFRPlaybackWebGL/index.html?m='.$_GET['mid'].'&t='.$enc.'" id="iFrame1"></iframe>';
                        break;

                    case 'United States':
                        echo '<iframe class="embed-responsive-item" src="https://webgltest-mh.s3.amazonaws.com/Main/StadiumUSAPlaybackWebGL/index.html?m='.$_GET['mid'].'&t='.$enc.'" id="iFrame1"></iframe>';
                        break;

                    case 'UAE':
                        echo '<iframe class="embed-responsive-item" src="https://webgltest-mh.s3.amazonaws.com/Main/StadiumUAEPlaybackWebGL/index.html?m='.$_GET['mid'].'&t='.$enc.'" id="iFrame1"></iframe>';
                        break;
                }

        }else{
            echo '<h5 class="mb-5">REPLAY IS PROCESSING. PLEASE TRY AGAIN LATER.</h5>';
        }
                
        
        return;
    }

    public function matchRegister()
    {
        $pageTitle = "OSAKA CHAMPIONSHIP WORLD CUP REGISTRATION";
        $user                       = auth()->user();
        
        //Get user game data
        
        include 'jwt_config.php';
        
        $ud_url="https://www.metahorse.site/users";
        
        $ch = curl_init($ud_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.jwttoken($user->username, $user->wallet_id)
          // 'Authorization: Bearer '.jwttoken('alice', '0x0E1Bfe045d45C365e1E5ccB754eb8199c6d7C9D3')
        ]);

        session(['jwt' => jwttoken($user->username, $user->wallet_id)]);
        
        $ud_response = curl_exec($ch);
        
        $widget['UGData']         = $ud_response;
        
        $UData = json_decode($ud_response);

        $gdata['horses'] = (array) $UData->horses;


        //new horse list

        $nud_url="https://www.metahorse.site/matches/rankingraced1/horses";
        
        $ch = curl_init($nud_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.jwttoken($user->username, $user->wallet_id)
          // 'Authorization: Bearer '.jwttoken('alice', '0x0E1Bfe045d45C365e1E5ccB754eb8199c6d7C9D3')
        ]);
        
        $nud_response = curl_exec($ch);
        
        $widget['nUGData']         = $nud_response;
        
        $nUData = json_decode($nud_response);
        
        
        //$_SESSION['G']=$widget['GBalance'];

        $gdata['nhorses'] = (array) $nUData;

        $gdata['back_link'] = url('url/dashboard');

        if(isset($_SERVER['HTTP_REFERER'])){
            $gdata['back_link'] = $_SERVER['HTTP_REFERER'];
        }


        //check match verify

        $mvud_url="https://www.metahorse.site/matches/rankingraced1/flag";
        
        $ch = curl_init($mvud_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.jwttoken($user->username, $user->wallet_id)
          // 'Authorization: Bearer '.jwttoken('alice', '0x0E1Bfe045d45C365e1E5ccB754eb8199c6d7C9D3')
        ]);
        
        $mvud_response = curl_exec($ch);

        if($mvud_response=='true'){
            return view($this->activeTemplate. 'user.match_register', compact('pageTitle','user', 'gdata', 'widget'));
        }else{
            $notify[] = ['error', '@lang("Action not allowed!")'];
            return back()->withNotify($notify);
        }
        
    }

    public function placeBet()
    {

        $pageTitle                  = 'Place Bet';
        $user                       = auth()->user();

        $pgnum = 0;

        if(isset($_GET['pgnum'])){
            $pgnum = $_GET['pgnum'];
        }

        include 'jwt_config.php';
        
        $ud_url="https://www.metahorse.site/matches/current/".$pgnum;
        
        $ch = curl_init($ud_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.jwttoken($user->username, $user->wallet_id)
          // 'Authorization: Bearer '.jwttoken('alice', '0x0E1Bfe045d45C365e1E5ccB754eb8199c6d7C9D3')
        ]);

        
        $ud_response = curl_exec($ch);
        
        $gdata['UGData']         = $ud_response;
        
        $gdata['current_match']= (array) json_decode($ud_response);

        return view($this->activeTemplate . 'user.place_bet', compact('pageTitle', 'user', 'gdata', 'pgnum'));
    }


    public function matchBet(Request $request, $id)
    {

        $pageTitle                  = 'Place Bet';
        $user                       = auth()->user();

        include 'jwt_config.php';
        
        $ud_url = "https://www.metahorse.site/matches/".$id."/odds";

        $ch = curl_init($ud_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.jwttoken($user->username, $user->wallet_id)
        ]);

        $ud_response = curl_exec($ch);

        $gdata['UGData']         = $ud_response;
        $gdata['current_match'] = json_decode($ud_response);

        return view($this->activeTemplate . 'user.match_bet', compact('pageTitle', 'user', 'gdata', 'id'));
    }

    public function matchPlaceBet(Request $request, $id)
    {
        $bets = $request->get('bets');
        $user = auth()->user();

        include 'jwt_config.php';

        $ud_url = "https://www.metahorse.site/matches/".$id."/bet";

        $ch = curl_init($ud_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($bets));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.jwttoken($user->username, $user->wallet_id)
        ]);

        $ud_response = curl_exec($ch);
        $response = json_decode($ud_response);

        if(isset($response->g)){
            // Update Session as well
            $request->session()->put('g', $response->g);
            return json_encode(['success' => true, 'g' => $response->g]);
        } else {
            return json_encode(['success' => false]);
        }
    }

    public function submitProfile(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
        ],[
            'firstname.required'=>'First name field is required',
            'lastname.required'=>'Last name field is required'
        ]);

        $user = Auth::user();

        $in['firstname'] = $request->firstname;
        $in['lastname'] = $request->lastname;
        $in['mobile'] = $request->mobile;

        $in['address'] = [
            'country' => @$user->address->country,
        ];

        $user->fill($in)->save();
        $notify[] = ['success', '@lang("Profile updated successfully.")'];
        return back()->withNotify($notify);
    }

    public function changePassword()
    {
        $pageTitle = 'Change password';
        return view($this->activeTemplate . 'user.password', compact('pageTitle'));
    }

    public function submitPassword(Request $request)
    {

        $password_validation = Password::min(6);
        $general = GeneralSetting::first();
        if ($general->secure_password) {
            $password_validation = $password_validation->mixedCase()->numbers()->symbols()->uncompromised();
        }

        $this->validate($request, [
            'current_password' => 'required',
            'password' => ['required','confirmed',$password_validation]
        ]);


        try {
            $user = auth()->user();
            if (Hash::check($request->current_password, $user->password)) {
                $password = Hash::make($request->password);
                $user->password = $password;
                $user->save();
                $notify[] = ['success', '@lang("Password changes successfully.")'];
                return back()->withNotify($notify);
            } else {
                $notify[] = ['error', 'The password doesn\'t match!'];
                return back()->withNotify($notify);
            }
        } catch (\PDOException $e) {
            $notify[] = ['error', $e->getMessage()];
            return back()->withNotify($notify);
        }
    }

    /*
     * Deposit History
     */
    public function depositHistory()
    {
        $pageTitle = 'Deposit History';
        $emptyMessage = 'No history found.';
        $logs = auth()->user()->deposits()->with(['gateway'])->orderBy('id','desc')->paginate(getPaginate());
        return view($this->activeTemplate.'user.deposit_history', compact('pageTitle', 'emptyMessage', 'logs'));
    }

    /*
     * Withdraw Operation
     */

    public function withdrawMoney()
    {
        $withdrawMethod = WithdrawMethod::where('status',1)->get();
        $pageTitle = 'Withdraw Money';
        return view($this->activeTemplate.'user.withdraw.methods', compact('pageTitle','withdrawMethod'));
    }

    public function withdrawStore(Request $request)
    {
        $this->validate($request, [
            'method_code' => 'required',
            'amount' => 'required|numeric'
        ]);
        $method = WithdrawMethod::where('id', $request->method_code)->where('status', 1)->firstOrFail();
        $user = auth()->user();
        if ($request->amount < $method->min_limit) {
            $notify[] = ['error', 'Your requested amount is smaller than minimum amount.'];
            return back()->withNotify($notify);
        }
        if ($request->amount > $method->max_limit) {
            $notify[] = ['error', 'Your requested amount is larger than maximum amount.'];
            return back()->withNotify($notify);
        }

        if ($request->amount > $user->balance) {
            $notify[] = ['error', 'You do not have sufficient balance for withdraw.'];
            return back()->withNotify($notify);
        }


        $charge = $method->fixed_charge + ($request->amount * $method->percent_charge / 100);
        $afterCharge = $request->amount - $charge;
        $finalAmount = $afterCharge * $method->rate;

        $withdraw = new Withdrawal();
        $withdraw->method_id = $method->id; // wallet method ID
        $withdraw->user_id = $user->id;
        $withdraw->amount = $request->amount;
        $withdraw->currency = $method->currency;
        $withdraw->rate = $method->rate;
        $withdraw->charge = $charge;
        $withdraw->final_amount = $finalAmount;
        $withdraw->after_charge = $afterCharge;
        $withdraw->trx = getTrx();
        $withdraw->save();
        session()->put('wtrx', $withdraw->trx);
        return redirect()->route('user.withdraw.preview');
    }

    public function withdrawPreview()
    {
        $withdraw = Withdrawal::with('method','user')->where('trx', session()->get('wtrx'))->where('status', 0)->orderBy('id','desc')->firstOrFail();
        $pageTitle = 'Withdraw Preview';
        return view($this->activeTemplate . 'user.withdraw.preview', compact('pageTitle','withdraw'));
    }


    public function withdrawSubmit(Request $request)
    {
        $general = GeneralSetting::first();
        $withdraw = Withdrawal::with('method','user')->where('trx', session()->get('wtrx'))->where('status', 0)->orderBy('id','desc')->firstOrFail();

        $rules = [];
        $inputField = [];
        if ($withdraw->method->user_data != null) {
            foreach ($withdraw->method->user_data as $key => $cus) {
                $rules[$key] = [$cus->validation];
                if ($cus->type == 'file') {
                    array_push($rules[$key], 'image');
                    array_push($rules[$key], new FileTypeValidate(['jpg','jpeg','png']));
                    array_push($rules[$key], 'max:2048');
                }
                if ($cus->type == 'text') {
                    array_push($rules[$key], 'max:191');
                }
                if ($cus->type == 'textarea') {
                    array_push($rules[$key], 'max:300');
                }
                $inputField[] = $key;
            }
        }

        $this->validate($request, $rules);

        $user = auth()->user();
        if ($user->ts) {
            $response = verifyG2fa($user,$request->authenticator_code);
            if (!$response) {
                $notify[] = ['error', 'Wrong verification code'];
                return back()->withNotify($notify);
            }
        }


        if ($withdraw->amount > $user->balance) {
            $notify[] = ['error', 'Your request amount is larger then your current balance.'];
            return back()->withNotify($notify);
        }

        $directory = date("Y")."/".date("m")."/".date("d");
        $path = imagePath()['verify']['withdraw']['path'].'/'.$directory;
        $collection = collect($request);
        $reqField = [];
        if ($withdraw->method->user_data != null) {
            foreach ($collection as $k => $v) {
                foreach ($withdraw->method->user_data as $inKey => $inVal) {
                    if ($k != $inKey) {
                        continue;
                    } else {
                        if ($inVal->type == 'file') {
                            if ($request->hasFile($inKey)) {
                                try {
                                    $reqField[$inKey] = [
                                        'field_name' => $directory.'/'.uploadImage($request[$inKey], $path),
                                        'type' => $inVal->type,
                                    ];
                                } catch (\Exception $exp) {
                                    $notify[] = ['error', 'Could not upload your ' . $request[$inKey]];
                                    return back()->withNotify($notify)->withInput();
                                }
                            }
                        } else {
                            $reqField[$inKey] = $v;
                            $reqField[$inKey] = [
                                'field_name' => $v,
                                'type' => $inVal->type,
                            ];
                        }
                    }
                }
            }
            $withdraw['withdraw_information'] = $reqField;
        } else {
            $withdraw['withdraw_information'] = null;
        }


        $withdraw->status = 2;
        $withdraw->save();
        $user->balance  -=  $withdraw->amount;
        $user->save();



        $transaction = new Transaction();
        $transaction->user_id = $withdraw->user_id;
        $transaction->amount = $withdraw->amount;
        $transaction->post_balance = $user->balance;
        $transaction->charge = $withdraw->charge;
        $transaction->trx_type = '-';
        $transaction->details = showAmount($withdraw->final_amount) . ' ' . $withdraw->currency . ' Withdraw Via ' . $withdraw->method->name;
        $transaction->trx =  $withdraw->trx;
        $transaction->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $user->id;
        $adminNotification->title = 'New withdraw request from '.$user->username;
        $adminNotification->click_url = urlPath('admin.withdraw.details',$withdraw->id);
        $adminNotification->save();

        notify($user, 'WITHDRAW_REQUEST', [
            'method_name' => $withdraw->method->name,
            'method_currency' => $withdraw->currency,
            'method_amount' => showAmount($withdraw->final_amount),
            'amount' => showAmount($withdraw->amount),
            'charge' => showAmount($withdraw->charge),
            'currency' => $general->cur_text,
            'rate' => showAmount($withdraw->rate),
            'trx' => $withdraw->trx,
            'post_balance' => showAmount($user->balance),
            'delay' => $withdraw->method->delay
        ]);

        $notify[] = ['success', 'Withdraw request sent successfully'];
        return redirect()->route('user.withdraw.history')->withNotify($notify);
    }

    public function withdrawLog()
    {
        $pageTitle = "Withdraw Log";
        $withdraws = Withdrawal::where('user_id', Auth::id())->where('status', '!=', 0)->with('method')->orderBy('id','desc')->paginate(getPaginate());
        $emptyMessage = "No Data Found!";
        return view($this->activeTemplate.'user.withdraw.log', compact('pageTitle','withdraws', 'emptyMessage'));
    }

    public function commissionsDeposit()
    {
        $pageTitle = 'Deposit Referral Commissions';
        $logs = CommissionLog::where('type','deposit')->where('to_id', auth()->user()->id)->with('user', 'bywho')->latest()->paginate(getPaginate());
        $emptyMessage = "No result found";

        return view($this->activeTemplate.'user.referral.commission', compact('pageTitle', 'logs', 'emptyMessage'));
    }

    public function commissionsBet()
    {
        $pageTitle = 'Referral Commissions on Bet';
        $logs = CommissionLog::where('type','bet')->where('to_id', auth()->user()->id)->with('user', 'bywho')->latest()->paginate(getPaginate());
        $emptyMessage = "No result found";

        return view($this->activeTemplate.'user.referral.commission', compact('pageTitle', 'logs', 'emptyMessage'));
    }

    public function commissionsWin()
    {
        $pageTitle = 'Referral Commissions on Won Bet';
        $logs = CommissionLog::where('type','win')->where('to_id', auth()->user()->id)->with('user', 'bywho')->latest()->paginate(getPaginate());
        $emptyMessage = "No result found";

        return view($this->activeTemplate.'user.referral.commission', compact('pageTitle', 'logs', 'emptyMessage'));
    }

    public function refMy($levelNo = 1)
    {
        $pageTitle = "My Referred Users";
        $emptyMessage = "No result found";
        $lev = 0;
        $userId = auth()->user()->id;
        while ($userId != null) {
            $user = User::where('ref_by',$userId)->first();
            if ($user) {
                $lev++;
                $userId = $user->id;
            }else{
                $userId = null;
            }
        }
        return view($this->activeTemplate. 'user.referral.users', compact('pageTitle','emptyMessage','levelNo','lev'));
    }

    public function show2faForm()
    {
        $general = GeneralSetting::first();
        $ga = new GoogleAuthenticator();
        $user = auth()->user();
        $secret = $ga->createSecret();
        $qrCodeUrl = $ga->getQRCodeGoogleUrl($user->username . '@' . $general->sitename, $secret);
        $pageTitle = 'Two Factor';
        return view($this->activeTemplate.'user.twofactor', compact('pageTitle', 'secret', 'qrCodeUrl'));
    }

    public function create2fa(Request $request)
    {
        $user = auth()->user();
        $this->validate($request, [
            'key' => 'required',
            'code' => 'required',
        ]);
        $response = verifyG2fa($user,$request->code,$request->key);
        if ($response) {
            $user->tsc = $request->key;
            $user->ts = 1;
            $user->save();
            $userAgent = getIpInfo();
            $osBrowser = osBrowser();
            notify($user, '2FA_ENABLE', [
                'operating_system' => @$osBrowser['os_platform'],
                'browser' => @$osBrowser['browser'],
                'ip' => @$userAgent['ip'],
                'time' => @$userAgent['time']
            ]);
            $notify[] = ['success', 'Google authenticator enabled successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Wrong verification code'];
            return back()->withNotify($notify);
        }
    }


    public function disable2fa(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
        ]);

        $user = auth()->user();
        $response = verifyG2fa($user,$request->code);
        if ($response) {
            $user->tsc = null;
            $user->ts = 0;
            $user->save();
            $userAgent = getIpInfo();
            $osBrowser = osBrowser();
            notify($user, '2FA_DISABLE', [
                'operating_system' => @$osBrowser['os_platform'],
                'browser' => @$osBrowser['browser'],
                'ip' => @$userAgent['ip'],
                'time' => @$userAgent['time']
            ]);
            $notify[] = ['success', 'Two factor authenticator disable successfully'];
        } else {
            $notify[] = ['error', 'Wrong verification code'];
        }
        return back()->withNotify($notify);
    }

    public function transactions()
    {
        $pageTitle = 'Transactions';
        $transactions = Transaction::where('user_id', auth()->user()->id)->latest()->paginate(getPaginate());
        $emptyMessage = 'No transaction found';

        return view($this->activeTemplate.'user.transaction', compact('pageTitle', 'transactions', 'emptyMessage'));
    }
}
