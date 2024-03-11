<?php

namespace App\Http\Controllers\Admin;

use App\Models\Deposit;
use App\Models\Gateway;
use App\Models\GeneralSetting;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

include 'AdminJWT.php';

class DepositController extends Controller
{
    protected $depoRelations = ['user', 'gateway'];

    public function pending()
    {
        $pageTitle = 'Pending Deposits';
        $emptyMessage = 'No pending deposits.';

        $uri=explode('/',$_SERVER['REQUEST_URI']);

        $token = generateToken();
        $jwt = generateJwt($token);

        $page=0;

        if(isset($_GET['page'])){
            $page=$_GET['page']-1;
        }
        
        
        $dud_url="https://www.metahorse.site/admin/logs/deposit/pending/".$page;

        $page++;

        if(isset($_GET['date'])){
            $dud_url.='?d='.$_GET['date'];
        }

        $ch = curl_init($dud_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.$jwt
          //'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ0b2tlbmtleSI6ImpqRW5qUDg3XC9HOGZ5NEIwRFo3azhMK25ETkNmOGR5VkZ5M2thWm54bFNxcUJOOEdWRjBCRTlvcVdBZXU1R1wvU2dIZ2d0THFXc2hVUUd5MVgySndST0pVM3FQa1hXYVUzbTdITk5oXC9yVlJnPSIsImp0aSI6IjkzRUQxQzU0LTk1NjctNDY3Ny1BODJCLTdFQUE4NEQ1NkJFOSIsIm5iZiI6MTY2MzQ5ODA4MCwiZXhwIjoxNjYzNDk4OTgwLCJpYXQiOjE2NjM0OTgwODAsImlzcyI6Ik1ldGFob3JzZUlzc3VlciIsImF1ZCI6Ik1ldGFob3JzZUF1ZGllbmNlIn0.yHRxlhc1-bzqTkmpR8XsRKKOrHkvQL7eO2YXVY_kPeo'
        ]);
        
        $dud_response = curl_exec($ch);

        $dep_list=json_decode($dud_response,1);

        $deposits = Deposit::where('method_code', '>=', 1000)->where('status', 2)->with($this->depoRelations)->orderBy('id','desc')->paginate(getPaginate());
        return view('admin.deposit.log', compact('pageTitle', 'emptyMessage', 'deposits', 'dep_list', 'uri', 'page'));
    }




    public function successful()
    {
        $pageTitle = 'Successful Deposits';
        $emptyMessage = 'No successful deposits.';

        $uri=explode('/',$_SERVER['REQUEST_URI']);

        $token = generateToken();
        $jwt = generateJwt($token);

        $page=0;

        if(isset($_GET['page'])){
            $page=$_GET['page']-1;
        }
        
        
        $dud_url="https://www.metahorse.site/admin/logs/deposit/successful/".$page;
        $page++;

        if(isset($_GET['date'])){
            $dud_url.='?d='.$_GET['date'];
        }

        $ch = curl_init($dud_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.$jwt
          //'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ0b2tlbmtleSI6ImpqRW5qUDg3XC9HOGZ5NEIwRFo3azhMK25ETkNmOGR5VkZ5M2thWm54bFNxcUJOOEdWRjBCRTlvcVdBZXU1R1wvU2dIZ2d0THFXc2hVUUd5MVgySndST0pVM3FQa1hXYVUzbTdITk5oXC9yVlJnPSIsImp0aSI6IjkzRUQxQzU0LTk1NjctNDY3Ny1BODJCLTdFQUE4NEQ1NkJFOSIsIm5iZiI6MTY2MzQ5ODA4MCwiZXhwIjoxNjYzNDk4OTgwLCJpYXQiOjE2NjM0OTgwODAsImlzcyI6Ik1ldGFob3JzZUlzc3VlciIsImF1ZCI6Ik1ldGFob3JzZUF1ZGllbmNlIn0.yHRxlhc1-bzqTkmpR8XsRKKOrHkvQL7eO2YXVY_kPeo'
        ]);
        
        $dud_response = curl_exec($ch);

        $dep_list=json_decode($dud_response,1);

        $deposits = Deposit::where('status', 1)->with($this->depoRelations)->orderBy('id','desc')->paginate(getPaginate());
        return view('admin.deposit.log', compact('pageTitle', 'emptyMessage', 'deposits', 'dep_list', 'uri', 'page'));
    }

    public function rejected()
    {
        $pageTitle = 'Rejected Deposits';
        $emptyMessage = 'No rejected deposits.';

        $uri=explode('/',$_SERVER['REQUEST_URI']);

        $token = generateToken();
        $jwt = generateJwt($token);

        $page=0;

        if(isset($_GET['page'])){
            $page=$_GET['page']-1;
        }
        $page++;

        if(isset($_GET['date'])){
            $dud_url.='?d='.$_GET['date'];
        }
        
        $dud_url="https://www.metahorse.site/admin/logs/deposit/rejected/".$page;

        $ch = curl_init($dud_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.$jwt
          //'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ0b2tlbmtleSI6ImpqRW5qUDg3XC9HOGZ5NEIwRFo3azhMK25ETkNmOGR5VkZ5M2thWm54bFNxcUJOOEdWRjBCRTlvcVdBZXU1R1wvU2dIZ2d0THFXc2hVUUd5MVgySndST0pVM3FQa1hXYVUzbTdITk5oXC9yVlJnPSIsImp0aSI6IjkzRUQxQzU0LTk1NjctNDY3Ny1BODJCLTdFQUE4NEQ1NkJFOSIsIm5iZiI6MTY2MzQ5ODA4MCwiZXhwIjoxNjYzNDk4OTgwLCJpYXQiOjE2NjM0OTgwODAsImlzcyI6Ik1ldGFob3JzZUlzc3VlciIsImF1ZCI6Ik1ldGFob3JzZUF1ZGllbmNlIn0.yHRxlhc1-bzqTkmpR8XsRKKOrHkvQL7eO2YXVY_kPeo'
        ]);
        
        $dud_response = curl_exec($ch);

        $dep_list=json_decode($dud_response,1);

        $deposits = Deposit::where('method_code', '>=', 1000)->where('status', 3)->with($this->depoRelations)->orderBy('id','desc')->paginate(getPaginate());
        return view('admin.deposit.log', compact('pageTitle', 'emptyMessage', 'deposits', 'dep_list', 'uri', 'page'));
    }

    public function deposit()
    {

        $pageTitle = 'Deposit History';
        $emptyMessage = 'No deposit history available.';

        $uri=explode('/',$_SERVER['REQUEST_URI']);

        $token = generateToken();
        $jwt = generateJwt($token);

        $page=0;

        if(isset($_GET['page'])){
            $page=$_GET['page']-1;
        }
        
        
        $dud_url="https://www.metahorse.site/admin/logs/deposit/".$page;

        $page++;

        if(isset($_GET['date'])){
            $dud_url.='?d='.$_GET['date'];
        }

        $ch = curl_init($dud_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.$jwt
          //'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ0b2tlbmtleSI6ImpqRW5qUDg3XC9HOGZ5NEIwRFo3azhMK25ETkNmOGR5VkZ5M2thWm54bFNxcUJOOEdWRjBCRTlvcVdBZXU1R1wvU2dIZ2d0THFXc2hVUUd5MVgySndST0pVM3FQa1hXYVUzbTdITk5oXC9yVlJnPSIsImp0aSI6IjkzRUQxQzU0LTk1NjctNDY3Ny1BODJCLTdFQUE4NEQ1NkJFOSIsIm5iZiI6MTY2MzQ5ODA4MCwiZXhwIjoxNjYzNDk4OTgwLCJpYXQiOjE2NjM0OTgwODAsImlzcyI6Ik1ldGFob3JzZUlzc3VlciIsImF1ZCI6Ik1ldGFob3JzZUF1ZGllbmNlIn0.yHRxlhc1-bzqTkmpR8XsRKKOrHkvQL7eO2YXVY_kPeo'
        ]);
        
        $dud_response = curl_exec($ch);

        $dep_list=json_decode($dud_response,1);

        $deposits = Deposit::with($this->depoRelations)->where('status','!=',0)->orderBy('id','desc')->paginate(getPaginate());
        $successful = 0;
        $pending = 0;
        $rejected = 0;
        return view('admin.deposit.log', compact('pageTitle', 'emptyMessage', 'deposits','successful','pending','rejected','dep_list', 'uri', 'page'));
    }

    public function depositViaMethod($method,$type = null){
        $method = Gateway::where('alias',$method)->firstOrFail();
        if ($type == 'approved') {
            $pageTitle = 'Approved Payment Via '.$method->name;
            $deposits = Deposit::where('method_code','>=',1000)->where('method_code',$method->code)->where('status', 1)->orderBy('id','desc')->with($this->depoRelations);
        }elseif($type == 'rejected'){
            $pageTitle = 'Rejected Payment Via '.$method->name;
            $deposits = Deposit::where('method_code','>=',1000)->where('method_code',$method->code)->where('status', 3)->orderBy('id','desc')->with($this->depoRelations);

        }elseif($type == 'successful'){
            $pageTitle = 'Successful Payment Via '.$method->name;
            $deposits = Deposit::where('status', 1)->where('method_code',$method->code)->orderBy('id','desc')->with($this->depoRelations);
        }elseif($type == 'pending'){
            $pageTitle = 'Pending Payment Via '.$method->name;
            $deposits = Deposit::where('method_code','>=',1000)->where('method_code',$method->code)->where('status', 2)->orderBy('id','desc')->with($this->depoRelations);
        }else{
            $pageTitle = 'Payment Via '.$method->name;
            $deposits = Deposit::where('status','!=',0)->where('method_code',$method->code)->orderBy('id','desc')->with($this->depoRelations);
        }
        $deposits = $deposits->paginate(getPaginate());
        $successful = $deposits->where('status',1)->sum('amount');
        $pending = $deposits->where('status',2)->sum('amount');
        $rejected = $deposits->where('status',3)->sum('amount');
        $methodAlias = $method->alias;
        $emptyMessage = 'No Deposit Found';
        return view('admin.deposit.log', compact('pageTitle', 'emptyMessage', 'deposits','methodAlias','successful','pending','rejected'));
    }

    public function search(Request $request, $scope)
    {
        $search = $request->search;
        $emptyMessage = 'No search result was found.';
        $deposits = Deposit::with($this->depoRelations)->where('status','!=',0)->where(function ($q) use ($search) {
            $q->where('trx', 'like', "%$search%")->orWhereHas('user', function ($user) use ($search) {
                $user->where('username', 'like', "%$search%");
            });
        });
        if ($scope == 'pending') {
            $pageTitle = 'Pending Deposits Search';
            $deposits = $deposits->where('method_code', '>=', 1000)->where('status', 2);
        }elseif($scope == 'approved'){
            $pageTitle = 'Approved Deposits Search';
            $deposits = $deposits->where('method_code', '>=', 1000)->where('status', 1);
        }elseif($scope == 'rejected'){
            $pageTitle = 'Rejected Deposits Search';
            $deposits = $deposits->where('method_code', '>=', 1000)->where('status', 3);
        }else{
            $pageTitle = 'Deposits History Search';
        }

        $deposits = $deposits->paginate(getPaginate());
        $pageTitle .= '-' . $search;

        return view('admin.deposit.log', compact('pageTitle', 'search', 'scope', 'emptyMessage', 'deposits'));
    }

    public function dateSearch(Request $request,$scope = null){
        $search = $request->date;
        if (!$search) {
            return back();
        }
        $date = explode('-',$search);
        $start = @$date[0];
        $end = @$date[1];
        // date validation
        $pattern = "/\d{2}\/\d{2}\/\d{4}/";
        if ($start && !preg_match($pattern,$start)) {
            $notify[] = ['error','Invalid date format'];
            return redirect()->route('admin.deposit.list')->withNotify($notify);
        }
        if ($end && !preg_match($pattern,$end)) {
            $notify[] = ['error','Invalid date format'];
            return redirect()->route('admin.deposit.list')->withNotify($notify);
        }


        if ($start) {
            $deposits = Deposit::where('status','!=',0)->whereDate('created_at',Carbon::parse($start));
        }
        if($end){
            $deposits = Deposit::where('status','!=',0)->whereDate('created_at','>=',Carbon::parse($start))->whereDate('created_at','<=',Carbon::parse($end));
        }
        if ($request->method) {
            $method = Gateway::where('alias',$request->method)->firstOrFail();
            $deposits = $deposits->where('method_code',$method->code);
        }
        if ($scope == 'pending') {
            $deposits = $deposits->where('method_code', '>=', 1000)->where('status', 2);
        }elseif($scope == 'approved'){
            $deposits = $deposits->where('method_code', '>=', 1000)->where('status', 1);
        }elseif($scope == 'rejected'){
            $deposits = $deposits->where('method_code', '>=', 1000)->where('status', 3);
        }
        $deposits = $deposits->with($this->depoRelations)->orderBy('id','desc')->paginate(getPaginate());
        $pageTitle = ' Deposits Log';
        $emptyMessage = 'No Deposit Found';
        $dateSearch = $search;
        return view('admin.deposit.log', compact('pageTitle', 'emptyMessage', 'deposits','dateSearch','scope'));
    }

    public function details($id)
    {
        $general = GeneralSetting::first();
        $deposit = Deposit::where('id', $id)->with($this->depoRelations)->firstOrFail();
        $pageTitle = $deposit->user->username.' requested ' . showAmount($deposit->amount) . ' '.$general->cur_text;
        $details = ($deposit->detail != null) ? json_encode($deposit->detail) : null;
        return view('admin.deposit.detail', compact('pageTitle', 'deposit','details'));
    }


    public function approve(Request $request)
    {

        $request->validate(['id' => 'required|integer']);
        $deposit = Deposit::where('id',$request->id)->where('status',2)->firstOrFail();
        $deposit->status = 1;
        $deposit->save();

        $user = User::find($deposit->user_id);
        $user->balance = $user->balance + $deposit->amount;
        $user->save();

        $transaction = new Transaction();
        $transaction->user_id = $deposit->user_id;
        $transaction->amount = $deposit->amount;
        $transaction->post_balance = $user->balance;
        $transaction->charge = $deposit->charge;
        $transaction->trx_type = '+';
        $transaction->details = 'Deposit Via ' . $deposit->gatewayCurrency()->name;
        $transaction->trx =  $deposit->trx;
        $transaction->save();

        $general = GeneralSetting::first();

        if ($general->deposit_commission == 1) {
            levelCommission($user->id, $deposit->amount, 'deposit', $deposit->trx, $general);
        }

        notify($user, 'DEPOSIT_APPROVE', [
            'method_name' => $deposit->gatewayCurrency()->name,
            'method_currency' => $deposit->method_currency,
            'method_amount' => showAmount($deposit->final_amo),
            'amount' => showAmount($deposit->amount),
            'charge' => showAmount($deposit->charge),
            'currency' => $general->cur_text,
            'rate' => showAmount($deposit->rate),
            'trx' => $deposit->trx,
            'post_balance' => showAmount($user->balance)
        ]);
        $notify[] = ['success', 'Deposit request has been approved.'];

        return redirect()->route('admin.deposit.pending')->withNotify($notify);
    }

    public function reject(Request $request)
    {

        $request->validate([
            'id' => 'required|integer',
            'message' => 'required|max:250'
        ]);
        $deposit = Deposit::where('id',$request->id)->where('status',2)->firstOrFail();

        $deposit->admin_feedback = $request->message;
        $deposit->status = 3;
        $deposit->save();

        $general = GeneralSetting::first();
        notify($deposit->user, 'DEPOSIT_REJECT', [
            'method_name' => $deposit->gatewayCurrency()->name,
            'method_currency' => $deposit->method_currency,
            'method_amount' => showAmount($deposit->final_amo),
            'amount' => showAmount($deposit->amount),
            'charge' => showAmount($deposit->charge),
            'currency' => $general->cur_text,
            'rate' => showAmount($deposit->rate),
            'trx' => $deposit->trx,
            'rejection_message' => $request->message
        ]);

        $notify[] = ['success', 'Deposit request has been rejected.'];
        return  redirect()->route('admin.deposit.pending')->withNotify($notify);

    }
}
