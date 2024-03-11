<?php

namespace App\Http\Controllers\Admin;

use App\Models\GeneralSetting;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use App\Models\WithdrawMethod;
use App\Models\Withdrawal;
use Carbon\Carbon;
use Illuminate\Http\Request;

include 'AdminJWT.php';

class WithdrawalController extends Controller
{
    public function pending()
    {
        $pageTitle = 'Pending Withdrawals';
        $withdrawals = Withdrawal::pending()->with(['user','method'])->orderBy('id','desc')->paginate(getPaginate());
        $emptyMessage = 'No withdrawal found';
        

        $uri=explode('/',$_SERVER['REQUEST_URI']);

        $token = generateToken();
        $jwt = generateJwt($token);

        $page=0;

        if(isset($_GET['page'])){
            $page=$_GET['page']-1;
        }
        
        
        $wud_url="https://www.metahorse.site/admin/logs/withdrawal/pending/".$page;

        $page++;

        if(isset($_GET['date'])){
            $wud_url.='?d='.$_GET['date'];
        }

        $ch = curl_init($wud_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.$jwt
          //'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ0b2tlbmtleSI6ImpqRW5qUDg3XC9HOGZ5NEIwRFo3azhMK25ETkNmOGR5VkZ5M2thWm54bFNxcUJOOEdWRjBCRTlvcVdBZXU1R1wvU2dIZ2d0THFXc2hVUUd5MVgySndST0pVM3FQa1hXYVUzbTdITk5oXC9yVlJnPSIsImp0aSI6IjkzRUQxQzU0LTk1NjctNDY3Ny1BODJCLTdFQUE4NEQ1NkJFOSIsIm5iZiI6MTY2MzQ5ODA4MCwiZXhwIjoxNjYzNDk4OTgwLCJpYXQiOjE2NjM0OTgwODAsImlzcyI6Ik1ldGFob3JzZUlzc3VlciIsImF1ZCI6Ik1ldGFob3JzZUF1ZGllbmNlIn0.yHRxlhc1-bzqTkmpR8XsRKKOrHkvQL7eO2YXVY_kPeo'
        ]);
        
        $wud_response = curl_exec($ch);

        $wd_list=json_decode($wud_response,1);

        return view('admin.withdraw.withdrawals', compact('pageTitle', 'withdrawals', 'emptyMessage', 'wd_list', 'uri', 'page'));
    }
    
    public function approved()
    {
        $pageTitle = 'Successful Withdrawals';
        $withdrawals = Withdrawal::approved()->with(['user','method'])->orderBy('id','desc')->paginate(getPaginate());
        $emptyMessage = 'No withdrawal found';
        
        $uri=explode('/',$_SERVER['REQUEST_URI']);

        $token = generateToken();
        $jwt = generateJwt($token);

        $page=0;

        if(isset($_GET['page'])){
            $page=$_GET['page']-1;
        }
        
        
        $wud_url="https://www.metahorse.site/admin/logs/withdrawal/successful/".$page;

        $page++;

        if(isset($_GET['date'])){
            $wud_url.='?d='.$_GET['date'];
        }

        $ch = curl_init($wud_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.$jwt
          //'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ0b2tlbmtleSI6ImpqRW5qUDg3XC9HOGZ5NEIwRFo3azhMK25ETkNmOGR5VkZ5M2thWm54bFNxcUJOOEdWRjBCRTlvcVdBZXU1R1wvU2dIZ2d0THFXc2hVUUd5MVgySndST0pVM3FQa1hXYVUzbTdITk5oXC9yVlJnPSIsImp0aSI6IjkzRUQxQzU0LTk1NjctNDY3Ny1BODJCLTdFQUE4NEQ1NkJFOSIsIm5iZiI6MTY2MzQ5ODA4MCwiZXhwIjoxNjYzNDk4OTgwLCJpYXQiOjE2NjM0OTgwODAsImlzcyI6Ik1ldGFob3JzZUlzc3VlciIsImF1ZCI6Ik1ldGFob3JzZUF1ZGllbmNlIn0.yHRxlhc1-bzqTkmpR8XsRKKOrHkvQL7eO2YXVY_kPeo'
        ]);
        
        $wud_response = curl_exec($ch);

        $wd_list=json_decode($wud_response,1);

        return view('admin.withdraw.withdrawals', compact('pageTitle', 'withdrawals', 'emptyMessage', 'wd_list', 'uri', 'page'));
    }

    public function rejected()
    {
        $pageTitle = 'Rejected Withdrawals';
        $withdrawals = Withdrawal::rejected()->with(['user','method'])->orderBy('id','desc')->paginate(getPaginate());
        $emptyMessage = 'No withdrawal found';
        $uri=explode('/',$_SERVER['REQUEST_URI']);

        $token = generateToken();
        $jwt = generateJwt($token);

        $page=0;

        if(isset($_GET['page'])){
            $page=$_GET['page']-1;
        }
        
        
        $wud_url="https://www.metahorse.site/admin/logs/withdrawal/rejected/".$page;

        $page++;

        if(isset($_GET['date'])){
            $wud_url.='?d='.$_GET['date'];
        }

        $ch = curl_init($wud_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.$jwt
          //'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ0b2tlbmtleSI6ImpqRW5qUDg3XC9HOGZ5NEIwRFo3azhMK25ETkNmOGR5VkZ5M2thWm54bFNxcUJOOEdWRjBCRTlvcVdBZXU1R1wvU2dIZ2d0THFXc2hVUUd5MVgySndST0pVM3FQa1hXYVUzbTdITk5oXC9yVlJnPSIsImp0aSI6IjkzRUQxQzU0LTk1NjctNDY3Ny1BODJCLTdFQUE4NEQ1NkJFOSIsIm5iZiI6MTY2MzQ5ODA4MCwiZXhwIjoxNjYzNDk4OTgwLCJpYXQiOjE2NjM0OTgwODAsImlzcyI6Ik1ldGFob3JzZUlzc3VlciIsImF1ZCI6Ik1ldGFob3JzZUF1ZGllbmNlIn0.yHRxlhc1-bzqTkmpR8XsRKKOrHkvQL7eO2YXVY_kPeo'
        ]);
        
        $wud_response = curl_exec($ch);

        $wd_list=json_decode($wud_response,1);

        return view('admin.withdraw.withdrawals', compact('pageTitle', 'withdrawals', 'emptyMessage', 'wd_list', 'uri', 'page'));
    }

    public function log()
    {
        $pageTitle = 'Withdrawals Log';
        $withdrawals = Withdrawal::where('status', '!=', 0)->with(['user','method'])->orderBy('id','desc')->paginate(getPaginate());
        $emptyMessage = 'No withdrawal history';

        $uri=explode('/',$_SERVER['REQUEST_URI']);

        $token = generateToken();
        $jwt = generateJwt($token);

        $page=0;

        if(isset($_GET['page'])){
            $page=$_GET['page']-1;
        }
        
        
        $wud_url="https://www.metahorse.site/admin/logs/withdrawal/".$page;

        $page++;

        if(isset($_GET['date'])){
            $wud_url.='?d='.$_GET['date'];
        }

        $ch = curl_init($wud_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.$jwt
          //'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ0b2tlbmtleSI6ImpqRW5qUDg3XC9HOGZ5NEIwRFo3azhMK25ETkNmOGR5VkZ5M2thWm54bFNxcUJOOEdWRjBCRTlvcVdBZXU1R1wvU2dIZ2d0THFXc2hVUUd5MVgySndST0pVM3FQa1hXYVUzbTdITk5oXC9yVlJnPSIsImp0aSI6IjkzRUQxQzU0LTk1NjctNDY3Ny1BODJCLTdFQUE4NEQ1NkJFOSIsIm5iZiI6MTY2MzQ5ODA4MCwiZXhwIjoxNjYzNDk4OTgwLCJpYXQiOjE2NjM0OTgwODAsImlzcyI6Ik1ldGFob3JzZUlzc3VlciIsImF1ZCI6Ik1ldGFob3JzZUF1ZGllbmNlIn0.yHRxlhc1-bzqTkmpR8XsRKKOrHkvQL7eO2YXVY_kPeo'
        ]);
        
        $wud_response = curl_exec($ch);

        $wd_list=json_decode($wud_response,1);

        return view('admin.withdraw.withdrawals', compact('pageTitle', 'withdrawals', 'emptyMessage', 'wd_list', 'uri', 'page'));
    }


    public function logViaMethod($methodId,$type = null){
        $method = WithdrawMethod::findOrFail($methodId);
        if ($type == 'approved') {
            $pageTitle = 'Approved Withdrawal Via '.$method->name;
            $withdrawals = Withdrawal::where('status', 1)->with(['user','method'])->where('method_id',$method->id)->orderBy('id','desc')->paginate(getPaginate());
        }elseif($type == 'rejected'){
            $pageTitle = 'Rejected Withdrawals Via '.$method->name;
            $withdrawals = Withdrawal::where('status', 3)->with(['user','method'])->where('method_id',$method->id)->orderBy('id','desc')->paginate(getPaginate());

        }elseif($type == 'pending'){
            $pageTitle = 'Pending Withdrawals Via '.$method->name;
            $withdrawals = Withdrawal::where('status', 2)->with(['user','method'])->where('method_id',$method->id)->orderBy('id','desc')->paginate(getPaginate());
        }else{
            $pageTitle = 'Withdrawals Via '.$method->name;
            $withdrawals = Withdrawal::where('status', '!=', 0)->with(['user','method'])->where('method_id',$method->id)->orderBy('id','desc')->paginate(getPaginate());
        }
        $emptyMessage = 'No withdrawal found';
        return view('admin.withdraw.withdrawals', compact('pageTitle', 'withdrawals', 'emptyMessage','method'));
    }



}
