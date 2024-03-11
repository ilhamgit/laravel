<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Events\ActionEvent;
use App\Http\Controllers\QueryController;

class SocketController extends Controller
{
   
   public function fetchWalletData(Request $request)
   {
        $input = $request->all();
        $connectionID = $input['id'];
        event(new ActionEvent('data', ['id'=>$connectionID]));
        exit;
   }
   
   public function updatewallet(Request $request)
   {
       $input = $request->all();
       $id = $input['id'];
       $to_sign = $input['to_sign'];
       $signature2 = $input['signature'];
       $secret = 'abc123';
       
       /**generate**/
    //   $to_sign = "0x". bin2hex(openssl_random_pseudo_bytes(32));
    
    //   $signature = "0x".hash_hmac('sha256', hex2bin(substr($to_sign,2)), $secret);
	   //$result = "Signature: " . $signature;

      
       /**generate ends**/
       
     
      
       //validate signature
      $signature = "0x".hash_hmac('sha256', hex2bin(substr($to_sign,2)), $secret);

	  if ($signature == $signature2) {
	      
	      if (!isset($input['G']) || !isset($input['P'])) {
	          return 'Missing required body';
	      }
	      
	      $g = $input['G'];
	      $p = $input['P'];
	      
	      $connectionID = $input['id'];
          event(new ActionEvent('data', ['id'=>$connectionID, 'message'=>['g'=>$g, 'p'=>$p]]));
	  } else {
	      return "not verified ({$signature} vs {$signature2})";
	  }
	
        exit;
   }
   
   public function query(Request $request)
   {
       $queryC = new QueryController;
       echo "<pre>";
       
       var_dump($queryC->swap_g_mbtc($request));
       var_dump($queryC->swap_mbtc_g($request));
       var_dump($queryC->standard_breed($request));
       var_dump($queryC->super_breed($request));
       var_dump($queryC->update_superhorse($request));
       exit;
   }
}
