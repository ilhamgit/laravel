<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommissionLog;
use App\Models\EmailLog;
use App\Models\Transaction;
use App\Models\UserLogin;
use App\Models\Match;
use Illuminate\Http\Request;
use App\Models\User;

include 'AdminJWT.php';

class ReportController extends Controller
{
    public function betReport()
    {
        $pageTitle = 'Betting Report';
        $emptyMessage = 'No data found';

        $matches = Match::whereHas('bets', function($q) {
            $q->where('status', '!=', 0);
        })->latest()->with(['category','league','questions','bets'])->paginate(getPaginate());

        //newapi

        $token = generateToken();
        $jwt = generateJwt($token);

        $page=0;


        if(isset($_GET['page'])){
            $page=$_GET['page']-1;
        }
        
        
        $bets_url="https://www.metahorse.site/admin/users/bets/".$page;

        $page++;

        if(isset($_GET['search'])&&$_GET['search']!=''){
            $bets_url="https://www.metahorse.site/admin/users/".$_GET['search']."/bets/".$page;
        }

        $ch = curl_init($bets_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.$jwt
          //'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ0b2tlbmtleSI6ImpqRW5qUDg3XC9HOGZ5NEIwRFo3azhMK25ETkNmOGR5VkZ5M2thWm54bFNxcUJOOEdWRjBCRTlvcVdBZXU1R1wvU2dIZ2d0THFXc2hVUUd5MVgySndST0pVM3FQa1hXYVUzbTdITk5oXC9yVlJnPSIsImp0aSI6IjkzRUQxQzU0LTk1NjctNDY3Ny1BODJCLTdFQUE4NEQ1NkJFOSIsIm5iZiI6MTY2MzQ5ODA4MCwiZXhwIjoxNjYzNDk4OTgwLCJpYXQiOjE2NjM0OTgwODAsImlzcyI6Ik1ldGFob3JzZUlzc3VlciIsImF1ZCI6Ik1ldGFob3JzZUF1ZGllbmNlIn0.yHRxlhc1-bzqTkmpR8XsRKKOrHkvQL7eO2YXVY_kPeo'
        ]);
        
        $bets_response = curl_exec($ch);

        $bets_list=json_decode($bets_response,1);

        return view('admin.reports.bet', compact('pageTitle', 'matches', 'emptyMessage', 'bets_list'));
    }

    public function betReportSearch(Request $request)
    {
        $search = $request->search;
        $pageTitle = 'Betting Report - ' . $search;
        $emptyMessage = 'No data found';

        //newapi

        $token = generateToken();
        $jwt = generateJwt($token);

        $page=0;


        if(isset($_GET['page'])){
            $page=$_GET['page']-1;
            ;
        }
        
        
        $bets_url="https://www.metahorse.site/admin/users/bets/".$page;

        if(isset($search)&&$search!=''){
            $bets_url="https://www.metahorse.site/admin/users/".$search."/bets/".$page;
        }

        $page++;

        $ch = curl_init($bets_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.$jwt
          //'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ0b2tlbmtleSI6ImpqRW5qUDg3XC9HOGZ5NEIwRFo3azhMK25ETkNmOGR5VkZ5M2thWm54bFNxcUJOOEdWRjBCRTlvcVdBZXU1R1wvU2dIZ2d0THFXc2hVUUd5MVgySndST0pVM3FQa1hXYVUzbTdITk5oXC9yVlJnPSIsImp0aSI6IjkzRUQxQzU0LTk1NjctNDY3Ny1BODJCLTdFQUE4NEQ1NkJFOSIsIm5iZiI6MTY2MzQ5ODA4MCwiZXhwIjoxNjYzNDk4OTgwLCJpYXQiOjE2NjM0OTgwODAsImlzcyI6Ik1ldGFob3JzZUlzc3VlciIsImF1ZCI6Ik1ldGFob3JzZUF1ZGllbmNlIn0.yHRxlhc1-bzqTkmpR8XsRKKOrHkvQL7eO2YXVY_kPeo'
        ]);
        
        $bets_response = curl_exec($ch);

        $bets_list=json_decode($bets_response,1);

        return view('admin.reports.bet', compact('pageTitle', 'emptyMessage', 'bets_list'));
    }

    public function transaction()
    {
        $pageTitle = 'Transaction Logs';
        $transactions = Transaction::with('user')->orderBy('id','desc')->paginate(getPaginate());
        $emptyMessage = 'No transactions.';

        //newapi

        $token = generateToken();
        $jwt = generateJwt($token);

        $linkno=1;

        $page=0;

        $searchby='status';

        $filter='pending';

        $logid='';

        $search='';

        if(isset($_GET['filter'])){
            $filter=$_GET['filter'];
        }

        if(isset($_GET['searchby'])){
            $searchby=$_GET['searchby'];
        }

        if(isset($_GET['logid'])){
            $logid=$_GET['logid'];
        }

        if(isset($_GET['search'])){
            $search=$_GET['search'];
        }

        if(isset($_GET['page'])){
            $page=$_GET['page']-1;
        }
        
        $trn_url="";

        switch ($searchby) {
            case 'username':
                $trn_url="https://www.metahorse.site/admin/logs/username/".$search."/".$page;
                break;

            case 'statususername':
                $trn_url="https://www.metahorse.site/admin/logs/username/".$search."/status/".$filter."/".$page;
                break;

            case 'logid':
                $trn_url="https://www.metahorse.site/admin/logs/".$logid;
                break;
            
            default:
                $trn_url="https://www.metahorse.site/admin/logs/status/".$filter."/".$page;
                break;
        }

        $page++;

        $ch = curl_init($trn_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.$jwt
          //'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ0b2tlbmtleSI6ImpqRW5qUDg3XC9HOGZ5NEIwRFo3azhMK25ETkNmOGR5VkZ5M2thWm54bFNxcUJOOEdWRjBCRTlvcVdBZXU1R1wvU2dIZ2d0THFXc2hVUUd5MVgySndST0pVM3FQa1hXYVUzbTdITk5oXC9yVlJnPSIsImp0aSI6IjkzRUQxQzU0LTk1NjctNDY3Ny1BODJCLTdFQUE4NEQ1NkJFOSIsIm5iZiI6MTY2MzQ5ODA4MCwiZXhwIjoxNjYzNDk4OTgwLCJpYXQiOjE2NjM0OTgwODAsImlzcyI6Ik1ldGFob3JzZUlzc3VlciIsImF1ZCI6Ik1ldGFob3JzZUF1ZGllbmNlIn0.yHRxlhc1-bzqTkmpR8XsRKKOrHkvQL7eO2YXVY_kPeo'
        ]);
        
        $trn_response = curl_exec($ch);

        $trans_list=json_decode($trn_response,1);


        return view('admin.reports.transactions', compact('pageTitle', 'transactions', 'emptyMessage','trans_list', 'page','filter', 'trn_url', 'linkno', 'searchby'));
    }

    public function transactionSearch(Request $request)
    {
        $search = $request->search;
        $filter = $request->filter;
        $pageTitle = 'Transaction Logs';
        $emptyMessage = 'No transactions.';

        $transactions = Transaction::with('user')->whereHas('user', function ($user) use ($search) {
            $user->where('username', 'like',"%$search%");
        })->orWhere('trx', $search)->orderBy('id','desc')->paginate(getPaginate());

        //newapi now

        $token = generateToken();
        $jwt = generateJwt($token);

        $page=0;

        if(isset($_GET['page'])){
            $page=$_GET['page']-1;
        }
        
        $linkno=2;

        $searchby='status';

        $filter='pending';

        $logid='';

        $search='';

        if(isset($_GET['filter'])){
            $filter=$_GET['filter'];
        }

        if(isset($_GET['searchby'])){
            $searchby=$_GET['searchby'];
        }

        if(isset($_GET['logid'])){
            $logid=$_GET['logid'];
        }

        if(isset($_GET['search'])){
            $search=$_GET['search'];
        }

        if(isset($_GET['page'])){
            $page=$_GET['page']-1;
        }
        
        $trn_url="";

        switch ($searchby) {
            case 'username':
                $trn_url="https://www.metahorse.site/admin/logs/username/".$search."/".$page;
                break;

            case 'statususername':
                $trn_url="https://www.metahorse.site/admin/logs/username/".$search."/status/".$filter."/".$page;
                break;

            case 'logid':
                $trn_url="https://www.metahorse.site/admin/logs/".$logid;
                break;
            
            default:
                $trn_url="https://www.metahorse.site/admin/logs/status/".$filter."/".$page;
                break;
        }

        $page++;

        $ch = curl_init($trn_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.$jwt
          //'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ0b2tlbmtleSI6ImpqRW5qUDg3XC9HOGZ5NEIwRFo3azhMK25ETkNmOGR5VkZ5M2thWm54bFNxcUJOOEdWRjBCRTlvcVdBZXU1R1wvU2dIZ2d0THFXc2hVUUd5MVgySndST0pVM3FQa1hXYVUzbTdITk5oXC9yVlJnPSIsImp0aSI6IjkzRUQxQzU0LTk1NjctNDY3Ny1BODJCLTdFQUE4NEQ1NkJFOSIsIm5iZiI6MTY2MzQ5ODA4MCwiZXhwIjoxNjYzNDk4OTgwLCJpYXQiOjE2NjM0OTgwODAsImlzcyI6Ik1ldGFob3JzZUlzc3VlciIsImF1ZCI6Ik1ldGFob3JzZUF1ZGllbmNlIn0.yHRxlhc1-bzqTkmpR8XsRKKOrHkvQL7eO2YXVY_kPeo'
        ]);
        
        $trn_response = curl_exec($ch);

        $trans_list=json_decode($trn_response,1);

        return view('admin.reports.transactions', compact('pageTitle', 'transactions', 'emptyMessage','search','trans_list', 'page', 'filter', 'trn_url', 'linkno', 'searchby'));
    }

    public function loginHistory(Request $request)
    {   

        //newapi

        $token = generateToken();
        $jwt = generateJwt($token);

        $page=0;

        $filter='';

        if(isset($request->filter)){
            $filter=$request->filter;
        }

        $search='';

        if(isset($request->search)){
            $search=$request->search;
        }

        if(isset($_GET['page'])){
            $page=$_GET['page']-1;
        }
        
        
        $rew_url="https://www.metahorse.site/admin/users/rewards/".$page;

        if($request->filter=='taken'){
            $rew_url="https://www.metahorse.site/admin/users/rewards/taken/".$page;
        }else if($request->filter=='nottaken'){
            $rew_url="https://www.metahorse.site/admin/users/rewards/nottaken/".$page;
        }else if($request->filter=='taken'&&$request->search!=''){
            $rew_url="https://www.metahorse.site/admin/users/".$request->search."/rewards/".$page;
        }else if($request->filter=='nottaken'&&$request->search!=''){
            $rew_url="https://www.metahorse.site/admin/users/".$request->search."/rewards/taken/".$page;
        }else if($request->search!=''){
            $rew_url="https://www.metahorse.site/admin/users/".$request->search."/rewards/".$page;
        }

        $page++;

        $ch = curl_init($rew_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.$jwt
          //'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ0b2tlbmtleSI6ImpqRW5qUDg3XC9HOGZ5NEIwRFo3azhMK25ETkNmOGR5VkZ5M2thWm54bFNxcUJOOEdWRjBCRTlvcVdBZXU1R1wvU2dIZ2d0THFXc2hVUUd5MVgySndST0pVM3FQa1hXYVUzbTdITk5oXC9yVlJnPSIsImp0aSI6IjkzRUQxQzU0LTk1NjctNDY3Ny1BODJCLTdFQUE4NEQ1NkJFOSIsIm5iZiI6MTY2MzQ5ODA4MCwiZXhwIjoxNjYzNDk4OTgwLCJpYXQiOjE2NjM0OTgwODAsImlzcyI6Ik1ldGFob3JzZUlzc3VlciIsImF1ZCI6Ik1ldGFob3JzZUF1ZGllbmNlIn0.yHRxlhc1-bzqTkmpR8XsRKKOrHkvQL7eO2YXVY_kPeo'
        ]);
        
        $rew_response = curl_exec($ch);

        $reward_list=json_decode($rew_response,1);

        $pageTitle = 'Daily Reward Log';
        $emptyMessage = 'No daily reward found.';
        $login_logs = UserLogin::orderBy('id','desc')->with('user')->paginate(getPaginate());
        return view('admin.reports.logins', compact('pageTitle', 'emptyMessage', 'login_logs','reward_list','page','filter','search'));
    }

    public function loginIpHistory($ip)
    {
        $pageTitle = 'Login By - ' . $ip;
        $login_logs = UserLogin::where('user_ip',$ip)->orderBy('id','desc')->with('user')->paginate(getPaginate());
        $emptyMessage = 'No users login found.';
        return view('admin.reports.logins', compact('pageTitle', 'emptyMessage', 'login_logs','ip'));

    }

    public function emailHistory(){
        $pageTitle = 'Email history';
        $logs = EmailLog::with('user')->orderBy('id','desc')->paginate(getPaginate());
        $emptyMessage = 'No data found';
        return view('admin.reports.email_history', compact('pageTitle', 'emptyMessage','logs'));
    }

    public function commissionsDeposit()
    {
        $pageTitle = 'Deposit Commission Log';
        $logs = CommissionLog::where('type','deposit')->with(['user','bywho'])->latest()->paginate(getPaginate());
        $emptyMessage = 'No deposit commission yet';
        return view('admin.reports.commission_log', compact('pageTitle', 'logs', 'emptyMessage'));
    }

    public function commissionsBet()
    {
        $pageTitle = 'Betting Commission Log';
        $logs = CommissionLog::where('type','bet')->with(['user','bywho'])->latest()->paginate(getPaginate());
        $emptyMessage = 'No betting commission yet';
        return view('admin.reports.commission_log', compact('pageTitle', 'logs', 'emptyMessage'));
    }

    public function commissionsWin()
    {
        $pageTitle = 'Bet winning Commission Log';
        $logs = CommissionLog::where('type','win')->with(['user','bywho'])->latest()->paginate(getPaginate());
        $emptyMessage = 'No bet winning commission yet';
        return view('admin.reports.commission_log', compact('pageTitle', 'logs', 'emptyMessage'));
    }

    public function commissionsSearch(Request $request)
    {
        $request->validate(['search' => 'required']);
        $search = $request->search;
        $pageTitle = 'Commission Log Search -'.$search;
        $logs = CommissionLog::whereHas('user', function ($user) use ($search) {
                $user->where('username', 'like',"%$search%");
            })->orWhere('trx', $search)->with(['user','bywho'])->latest()->paginate(getPaginate());
        $emptyMessage = 'No commission data found';
        return view('admin.reports.commission_log', compact('pageTitle', 'logs', 'emptyMessage','search'));
    }
}
