<?php

namespace App\Http\Controllers;

use Elliptic\EC;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use kornrunner\Keccak;
use DB;
use Auth;
use App\Models\User;

class LoginController
{
    public function message(): string
    {
        $nonce = Str::random();
        $message = "Sign this message to confirm you own this wallet address. This action will not cost any gas fees.\n\nNonce: " ;

        session()->put('sign_message', $message);

        return $message;
    }

    public function form()
    {
        echo '

        <form method="post">
        '.csrf_field().'
        </form>

        ';

        return;
    }

    public function verify(Request $request): string
    {
        $user = User::where('wallet_id', $request->input('address'))->first();
        
        if($user){
            Auth::login($user);
            
            $_SESSION['wallet']=$request->input('address');
            
			$result = $user;
		} else {
			$result = 'false';
 		}


        // $user=DB::table('users')->select('id')->where('wallet_id', $request->input('address'))->get();

        // $result = $user;
        
        // If $result is true, perform additional logic like logging the user in, or by creating an account if one doesn't exist based on the Ethereum address
        return $result;
    }

}