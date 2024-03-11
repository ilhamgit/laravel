<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportAttachment;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;
include 'AdminJWT.php';


class ConfigurationController extends Controller
{
    public function referralBet()
    {
        $pageTitle = 'Referral Bet Multipliers';
        $emptyMessage = 'No Data found.';
        $items = SupportTicket::orderBy('id','desc')->with('user')->paginate(getPaginate());

        //newapi

        $uri=explode('/',$_SERVER['REQUEST_URI']);

        $token = generateToken();
        $jwt = generateJwt($token);

        $page=0;


        if(isset($_GET['page'])){
            $page=$_GET['page']-1;
        }
        
        
        $referral_url="https://www.metahorse.site/admin/matches/spmultipliers";

        $page++;

        $ch = curl_init($referral_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.$jwt
          //'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ0b2tlbmtleSI6ImpqRW5qUDg3XC9HOGZ5NEIwRFo3azhMK25ETkNmOGR5VkZ5M2thWm54bFNxcUJOOEdWRjBCRTlvcVdBZXU1R1wvU2dIZ2d0THFXc2hVUUd5MVgySndST0pVM3FQa1hXYVUzbTdITk5oXC9yVlJnPSIsImp0aSI6IjkzRUQxQzU0LTk1NjctNDY3Ny1BODJCLTdFQUE4NEQ1NkJFOSIsIm5iZiI6MTY2MzQ5ODA4MCwiZXhwIjoxNjYzNDk4OTgwLCJpYXQiOjE2NjM0OTgwODAsImlzcyI6Ik1ldGFob3JzZUlzc3VlciIsImF1ZCI6Ik1ldGFob3JzZUF1ZGllbmNlIn0.yHRxlhc1-bzqTkmpR8XsRKKOrHkvQL7eO2YXVY_kPeo'
        ]);
        
        $referral_response = curl_exec($ch);

        $referral_list=json_decode($referral_response,1);

        return view('admin.configuration.referral_bet', compact('items', 'pageTitle','emptyMessage', 'referral_list'));
    }

    public function updateBetsAutoRaceForm()
    {
        $emptyMessage = 'No Data found.';
        $pageTitle = 'Update Referral Bet Multipliers - Auto Race';

        //newapi

        $uri=explode('/',$_SERVER['REQUEST_URI']);

        $token = generateToken();
        $jwt = generateJwt($token);

        $page=0;


        if(isset($_GET['page'])){
            $page=$_GET['page']-1;
        }
        
        
        $bets_url="https://www.metahorse.site/admin/matches/spmultipliers";

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

        $bets_list=$bets_list['autoRaces'];

        $update='autoRaces';

        return view('admin.configuration.update_bets', compact('pageTitle','emptyMessage','bets_list','update'));
    }

    public function updateBetsRaceD1Form()
    {
        $emptyMessage = 'No Data found.';
        $pageTitle = 'Update Referral Bet Multipliers - Ranking Race D1';

        //newapi

        $uri=explode('/',$_SERVER['REQUEST_URI']);

        $token = generateToken();
        $jwt = generateJwt($token);

        $page=0;


        if(isset($_GET['page'])){
            $page=$_GET['page']-1;
        }
        
        
        $bets_url="https://www.metahorse.site/admin/matches/spmultipliers";

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

        $bets_list=$bets_list['rankingRaceD1s'];

        $update='rankingRaceD1s';

        return view('admin.configuration.update_bets', compact('pageTitle','emptyMessage','bets_list', 'update'));
    }

    public function updateBetsRaceD2Form()
    {
        $emptyMessage = 'No Data found.';
        $pageTitle = 'Update Referral Bet Multipliers - Ranking Race D2';

        //newapi

        $uri=explode('/',$_SERVER['REQUEST_URI']);

        $token = generateToken();
        $jwt = generateJwt($token);

        $page=0;


        if(isset($_GET['page'])){
            $page=$_GET['page']-1;
        }
        
        
        $bets_url="https://www.metahorse.site/admin/matches/spmultipliers";

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

        $bets_list=$bets_list['rankingRaceD2s'];

        $update='rankingRaceD2s';

        return view('admin.configuration.update_bets', compact('pageTitle','emptyMessage','bets_list', 'update'));
    }

    public function updateBetsRaceD3Form()
    {
        $emptyMessage = 'No Data found.';
        $pageTitle = 'Update Referral Bet Multipliers - Ranking Race D3';

        //newapi

        $uri=explode('/',$_SERVER['REQUEST_URI']);

        $token = generateToken();
        $jwt = generateJwt($token);

        $page=0;


        if(isset($_GET['page'])){
            $page=$_GET['page']-1;
        }
        
        
        $bets_url="https://www.metahorse.site/admin/matches/spmultipliers";

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

        $bets_list=$bets_list['rankingRaceD3s'];

        $update='rankingRaceD3s';

        return view('admin.configuration.update_bets', compact('pageTitle','emptyMessage','bets_list', 'update'));
    }

    public function updateBets(Request $request)
    {

        $token = generateToken();
        $jwt = generateJwt($token);


        $url = '';

        $no=0;

        $new_array=array();

        foreach ($request->update as $num => $data) {
            $new_array[]=$data;
        }

        if($request->update_type=='autoRaces'){
            $url = 'https://www.metahorse.site/admin/matches/spmultipliers/autorace';
        }else if($request->update_type=='rankingRaceD1s'){
            $url = 'https://www.metahorse.site/admin/matches/spmultipliers/rankingraced1';
        }else if($request->update_type=='rankingRaceD2s'){
            $url = 'https://www.metahorse.site/admin/matches/spmultipliers/rankingraced2';
        }else if($request->update_type=='rankingRaceD3s'){
            $url = 'https://www.metahorse.site/admin/matches/spmultipliers/rankingraced3';
        }

        // Collection object

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS,  json_encode($new_array));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.$jwt
          //'Authorization: Bearer '.jwttoken('alice', '0x0E1Bfe045d45C365e1E5ccB754eb8199c6d7C9D3')
        ]);

        $response = curl_exec($ch);

        $dec_response = json_decode($response,1);

        if($dec_response=='true'){
            $notify[] = ['success', 'Updated!'];
            return back()->withNotify($notify);
        }else{
            $notify[] = ['error', 'Not Update!'];
            return back()->withNotify($notify);
        }

        //echo $request->update_type.'<br>';

        //echo $jwt.'<br>';

        //echo json_encode($new_array);

        //return;
    }



    public function currentSeason()
    {
        $pageTitle = 'Current Season';
        $emptyMessage = 'No Data found.';
        $items = SupportTicket::whereIn('status', [0,2])->orderBy('priority', 'DESC')->orderBy('id','desc')->with('user')->paginate(getPaginate());

        //newapi

        $uri=explode('/',$_SERVER['REQUEST_URI']);

        $token = generateToken();
        $jwt = generateJwt($token);

        $page=0;


        if(isset($_GET['page'])){
            $page=$_GET['page']-1;
        }
        
        
        $season_url="https://www.metahorse.site/admin/seasons/latest";

        $page++;

        $ch = curl_init($season_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.$jwt
          //'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ0b2tlbmtleSI6ImpqRW5qUDg3XC9HOGZ5NEIwRFo3azhMK25ETkNmOGR5VkZ5M2thWm54bFNxcUJOOEdWRjBCRTlvcVdBZXU1R1wvU2dIZ2d0THFXc2hVUUd5MVgySndST0pVM3FQa1hXYVUzbTdITk5oXC9yVlJnPSIsImp0aSI6IjkzRUQxQzU0LTk1NjctNDY3Ny1BODJCLTdFQUE4NEQ1NkJFOSIsIm5iZiI6MTY2MzQ5ODA4MCwiZXhwIjoxNjYzNDk4OTgwLCJpYXQiOjE2NjM0OTgwODAsImlzcyI6Ik1ldGFob3JzZUlzc3VlciIsImF1ZCI6Ik1ldGFob3JzZUF1ZGllbmNlIn0.yHRxlhc1-bzqTkmpR8XsRKKOrHkvQL7eO2YXVY_kPeo'
        ]);
        
        $season_response = curl_exec($ch);

        $season_list=json_decode($season_response,1);


        return view('admin.configuration.season', compact('items', 'pageTitle','emptyMessage','season_list'));
    }

    public function updateSeasonForm()
    {
        $pageTitle = 'Current Season - Update';
        $emptyMessage = 'No Data found.';
        $items = SupportTicket::whereIn('status', [0,2])->orderBy('priority', 'DESC')->orderBy('id','desc')->with('user')->paginate(getPaginate());

        //newapi

        $uri=explode('/',$_SERVER['REQUEST_URI']);

        $token = generateToken();
        $jwt = generateJwt($token);

        $page=0;


        if(isset($_GET['page'])){
            $page=$_GET['page']-1;
        }
        
        
        $season_url="https://www.metahorse.site/admin/seasons/latest";

        $page++;

        $ch = curl_init($season_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.$jwt
          //'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ0b2tlbmtleSI6ImpqRW5qUDg3XC9HOGZ5NEIwRFo3azhMK25ETkNmOGR5VkZ5M2thWm54bFNxcUJOOEdWRjBCRTlvcVdBZXU1R1wvU2dIZ2d0THFXc2hVUUd5MVgySndST0pVM3FQa1hXYVUzbTdITk5oXC9yVlJnPSIsImp0aSI6IjkzRUQxQzU0LTk1NjctNDY3Ny1BODJCLTdFQUE4NEQ1NkJFOSIsIm5iZiI6MTY2MzQ5ODA4MCwiZXhwIjoxNjYzNDk4OTgwLCJpYXQiOjE2NjM0OTgwODAsImlzcyI6Ik1ldGFob3JzZUlzc3VlciIsImF1ZCI6Ik1ldGFob3JzZUF1ZGllbmNlIn0.yHRxlhc1-bzqTkmpR8XsRKKOrHkvQL7eO2YXVY_kPeo'
        ]);
        
        $season_response = curl_exec($ch);

        $season_list=json_decode($season_response,1);


        return view('admin.configuration.update_season', compact('items', 'pageTitle','emptyMessage','season_list'));
    }

    public function updateSeason(Request $request)
    {

        $token = generateToken();
        $jwt = generateJwt($token);

        $url = 'https://www.metahorse.site/admin/seasons/latest';

        // Collection object
        $data = array ("recurringNextDayOfWeek"=>$request->nextday, "recurringNextGap"=>$request->nextgap, "recurringMinimumHorse"=>$request->minhorse);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS,  json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.$jwt
          //'Authorization: Bearer '.jwttoken('alice', '0x0E1Bfe045d45C365e1E5ccB754eb8199c6d7C9D3')
        ]);

        $response = curl_exec($ch);

        $dec_response = json_decode($response,1);


        $notify[] = ['info', $response];
        return back()->withNotify($notify);
    }



    public function rewards()
    {
        $emptyMessage = 'No Data found.';
        $pageTitle = 'Rewards';

        //newapi

        $uri=explode('/',$_SERVER['REQUEST_URI']);

        $token = generateToken();
        $jwt = generateJwt($token);

        $page=0;


        if(isset($_GET['page'])){
            $page=$_GET['page']-1;
        }
        
        
        $rewards_url="https://www.metahorse.site/admin/matches/rewards";

        $page++;

        $ch = curl_init($rewards_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.$jwt
          //'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ0b2tlbmtleSI6ImpqRW5qUDg3XC9HOGZ5NEIwRFo3azhMK25ETkNmOGR5VkZ5M2thWm54bFNxcUJOOEdWRjBCRTlvcVdBZXU1R1wvU2dIZ2d0THFXc2hVUUd5MVgySndST0pVM3FQa1hXYVUzbTdITk5oXC9yVlJnPSIsImp0aSI6IjkzRUQxQzU0LTk1NjctNDY3Ny1BODJCLTdFQUE4NEQ1NkJFOSIsIm5iZiI6MTY2MzQ5ODA4MCwiZXhwIjoxNjYzNDk4OTgwLCJpYXQiOjE2NjM0OTgwODAsImlzcyI6Ik1ldGFob3JzZUlzc3VlciIsImF1ZCI6Ik1ldGFob3JzZUF1ZGllbmNlIn0.yHRxlhc1-bzqTkmpR8XsRKKOrHkvQL7eO2YXVY_kPeo'
        ]);
        
        $rewards_response = curl_exec($ch);

        $rewards_list=json_decode($rewards_response,1);

        return view('admin.configuration.rewards', compact('pageTitle','emptyMessage','rewards_list'));
    }

    public function updateRewardsAutoRaceForm()
    {
        $emptyMessage = 'No Data found.';
        $pageTitle = 'Update Rewards - Auto Race';

        //newapi

        $uri=explode('/',$_SERVER['REQUEST_URI']);

        $token = generateToken();
        $jwt = generateJwt($token);

        $page=0;


        if(isset($_GET['page'])){
            $page=$_GET['page']-1;
        }
        
        
        $rewards_url="https://www.metahorse.site/admin/matches/rewards";

        $page++;

        $ch = curl_init($rewards_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.$jwt
          //'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ0b2tlbmtleSI6ImpqRW5qUDg3XC9HOGZ5NEIwRFo3azhMK25ETkNmOGR5VkZ5M2thWm54bFNxcUJOOEdWRjBCRTlvcVdBZXU1R1wvU2dIZ2d0THFXc2hVUUd5MVgySndST0pVM3FQa1hXYVUzbTdITk5oXC9yVlJnPSIsImp0aSI6IjkzRUQxQzU0LTk1NjctNDY3Ny1BODJCLTdFQUE4NEQ1NkJFOSIsIm5iZiI6MTY2MzQ5ODA4MCwiZXhwIjoxNjYzNDk4OTgwLCJpYXQiOjE2NjM0OTgwODAsImlzcyI6Ik1ldGFob3JzZUlzc3VlciIsImF1ZCI6Ik1ldGFob3JzZUF1ZGllbmNlIn0.yHRxlhc1-bzqTkmpR8XsRKKOrHkvQL7eO2YXVY_kPeo'
        ]);
        
        $rewards_response = curl_exec($ch);

        $rewards_list=json_decode($rewards_response,1);

        $rewards_list=$rewards_list['autoRaces'];

        $update='autoRaces';

        return view('admin.configuration.update_rewards', compact('pageTitle','emptyMessage','rewards_list','update'));
    }

    public function updateRewardsRaceD1Form()
    {
        $emptyMessage = 'No Data found.';
        $pageTitle = 'Update Rewards - Ranking Race D1';

        //newapi

        $uri=explode('/',$_SERVER['REQUEST_URI']);

        $token = generateToken();
        $jwt = generateJwt($token);

        $page=0;


        if(isset($_GET['page'])){
            $page=$_GET['page']-1;
        }
        
        
        $rewards_url="https://www.metahorse.site/admin/matches/rewards";

        $page++;

        $ch = curl_init($rewards_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.$jwt
          //'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ0b2tlbmtleSI6ImpqRW5qUDg3XC9HOGZ5NEIwRFo3azhMK25ETkNmOGR5VkZ5M2thWm54bFNxcUJOOEdWRjBCRTlvcVdBZXU1R1wvU2dIZ2d0THFXc2hVUUd5MVgySndST0pVM3FQa1hXYVUzbTdITk5oXC9yVlJnPSIsImp0aSI6IjkzRUQxQzU0LTk1NjctNDY3Ny1BODJCLTdFQUE4NEQ1NkJFOSIsIm5iZiI6MTY2MzQ5ODA4MCwiZXhwIjoxNjYzNDk4OTgwLCJpYXQiOjE2NjM0OTgwODAsImlzcyI6Ik1ldGFob3JzZUlzc3VlciIsImF1ZCI6Ik1ldGFob3JzZUF1ZGllbmNlIn0.yHRxlhc1-bzqTkmpR8XsRKKOrHkvQL7eO2YXVY_kPeo'
        ]);
        
        $rewards_response = curl_exec($ch);

        $rewards_list=json_decode($rewards_response,1);

        $rewards_list=$rewards_list['rankingRaceD1s'];

        $update='rankingRaceD1s';

        return view('admin.configuration.update_rewards', compact('pageTitle','emptyMessage','rewards_list', 'update'));
    }

    public function updateRewardsRaceD2Form()
    {
        $emptyMessage = 'No Data found.';
        $pageTitle = 'Update Rewards - Ranking Race D2';

        //newapi

        $uri=explode('/',$_SERVER['REQUEST_URI']);

        $token = generateToken();
        $jwt = generateJwt($token);

        $page=0;


        if(isset($_GET['page'])){
            $page=$_GET['page']-1;
        }
        
        
        $rewards_url="https://www.metahorse.site/admin/matches/rewards";

        $page++;

        $ch = curl_init($rewards_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.$jwt
          //'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ0b2tlbmtleSI6ImpqRW5qUDg3XC9HOGZ5NEIwRFo3azhMK25ETkNmOGR5VkZ5M2thWm54bFNxcUJOOEdWRjBCRTlvcVdBZXU1R1wvU2dIZ2d0THFXc2hVUUd5MVgySndST0pVM3FQa1hXYVUzbTdITk5oXC9yVlJnPSIsImp0aSI6IjkzRUQxQzU0LTk1NjctNDY3Ny1BODJCLTdFQUE4NEQ1NkJFOSIsIm5iZiI6MTY2MzQ5ODA4MCwiZXhwIjoxNjYzNDk4OTgwLCJpYXQiOjE2NjM0OTgwODAsImlzcyI6Ik1ldGFob3JzZUlzc3VlciIsImF1ZCI6Ik1ldGFob3JzZUF1ZGllbmNlIn0.yHRxlhc1-bzqTkmpR8XsRKKOrHkvQL7eO2YXVY_kPeo'
        ]);
        
        $rewards_response = curl_exec($ch);

        $rewards_list=json_decode($rewards_response,1);

        $rewards_list=$rewards_list['rankingRaceD2s'];

        $update='rankingRaceD2s';

        return view('admin.configuration.update_rewards', compact('pageTitle','emptyMessage','rewards_list', 'update'));
    }

    public function updateRewardsRaceD3Form()
    {
        $emptyMessage = 'No Data found.';
        $pageTitle = 'Update Rewards - Ranking Race D3';

        //newapi

        $uri=explode('/',$_SERVER['REQUEST_URI']);

        $token = generateToken();
        $jwt = generateJwt($token);

        $page=0;


        if(isset($_GET['page'])){
            $page=$_GET['page']-1;
        }
        
        
        $rewards_url="https://www.metahorse.site/admin/matches/rewards";

        $page++;

        $ch = curl_init($rewards_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.$jwt
          //'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ0b2tlbmtleSI6ImpqRW5qUDg3XC9HOGZ5NEIwRFo3azhMK25ETkNmOGR5VkZ5M2thWm54bFNxcUJOOEdWRjBCRTlvcVdBZXU1R1wvU2dIZ2d0THFXc2hVUUd5MVgySndST0pVM3FQa1hXYVUzbTdITk5oXC9yVlJnPSIsImp0aSI6IjkzRUQxQzU0LTk1NjctNDY3Ny1BODJCLTdFQUE4NEQ1NkJFOSIsIm5iZiI6MTY2MzQ5ODA4MCwiZXhwIjoxNjYzNDk4OTgwLCJpYXQiOjE2NjM0OTgwODAsImlzcyI6Ik1ldGFob3JzZUlzc3VlciIsImF1ZCI6Ik1ldGFob3JzZUF1ZGllbmNlIn0.yHRxlhc1-bzqTkmpR8XsRKKOrHkvQL7eO2YXVY_kPeo'
        ]);
        
        $rewards_response = curl_exec($ch);

        $rewards_list=json_decode($rewards_response,1);

        $rewards_list=$rewards_list['rankingRaceD3s'];

        $update='rankingRaceD3s';

        return view('admin.configuration.update_rewards', compact('pageTitle','emptyMessage','rewards_list', 'update'));
    }

    public function updateRewardsLuckyRaceForm()
    {
        $emptyMessage = 'No Data found.';
        $pageTitle = 'Update Rewards - Lucky Race';

        //newapi

        $uri=explode('/',$_SERVER['REQUEST_URI']);

        $token = generateToken();
        $jwt = generateJwt($token);

        $page=0;


        if(isset($_GET['page'])){
            $page=$_GET['page']-1;
        }
        
        
        $rewards_url="https://www.metahorse.site/admin/matches/rewards";

        $page++;

        $ch = curl_init($rewards_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.$jwt
          //'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ0b2tlbmtleSI6ImpqRW5qUDg3XC9HOGZ5NEIwRFo3azhMK25ETkNmOGR5VkZ5M2thWm54bFNxcUJOOEdWRjBCRTlvcVdBZXU1R1wvU2dIZ2d0THFXc2hVUUd5MVgySndST0pVM3FQa1hXYVUzbTdITk5oXC9yVlJnPSIsImp0aSI6IjkzRUQxQzU0LTk1NjctNDY3Ny1BODJCLTdFQUE4NEQ1NkJFOSIsIm5iZiI6MTY2MzQ5ODA4MCwiZXhwIjoxNjYzNDk4OTgwLCJpYXQiOjE2NjM0OTgwODAsImlzcyI6Ik1ldGFob3JzZUlzc3VlciIsImF1ZCI6Ik1ldGFob3JzZUF1ZGllbmNlIn0.yHRxlhc1-bzqTkmpR8XsRKKOrHkvQL7eO2YXVY_kPeo'
        ]);
        
        $rewards_response = curl_exec($ch);

        $rewards_list=json_decode($rewards_response,1);

        $rewards_list=$rewards_list['luckyRaces'];

        $update='luckyRaces';

        return view('admin.configuration.update_rewards', compact('pageTitle','emptyMessage','rewards_list', 'update'));
    }

    public function updateRewardsSuperRaceForm()
    {
        $emptyMessage = 'No Data found.';
        $pageTitle = 'Update Rewards - Super Race';

        //newapi

        $uri=explode('/',$_SERVER['REQUEST_URI']);

        $token = generateToken();
        $jwt = generateJwt($token);

        $page=0;


        if(isset($_GET['page'])){
            $page=$_GET['page']-1;
        }
        
        
        $rewards_url="https://www.metahorse.site/admin/matches/rewards";

        $page++;

        $ch = curl_init($rewards_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.$jwt
          //'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ0b2tlbmtleSI6ImpqRW5qUDg3XC9HOGZ5NEIwRFo3azhMK25ETkNmOGR5VkZ5M2thWm54bFNxcUJOOEdWRjBCRTlvcVdBZXU1R1wvU2dIZ2d0THFXc2hVUUd5MVgySndST0pVM3FQa1hXYVUzbTdITk5oXC9yVlJnPSIsImp0aSI6IjkzRUQxQzU0LTk1NjctNDY3Ny1BODJCLTdFQUE4NEQ1NkJFOSIsIm5iZiI6MTY2MzQ5ODA4MCwiZXhwIjoxNjYzNDk4OTgwLCJpYXQiOjE2NjM0OTgwODAsImlzcyI6Ik1ldGFob3JzZUlzc3VlciIsImF1ZCI6Ik1ldGFob3JzZUF1ZGllbmNlIn0.yHRxlhc1-bzqTkmpR8XsRKKOrHkvQL7eO2YXVY_kPeo'
        ]);
        
        $rewards_response = curl_exec($ch);

        $rewards_list=json_decode($rewards_response,1);

        $rewards_list=$rewards_list['superRaces'];

        $update='superRaces';

        return view('admin.configuration.update_rewards', compact('pageTitle','emptyMessage','rewards_list', 'update'));
    }

    public function updateRewards(Request $request)
    {

        $token = generateToken();
        $jwt = generateJwt($token);


        $url = '';

        $no=0;

        $new_array=array();

        foreach ($request->update as $num => $data) {
            $new_array[]=$data;
        }

        if($request->update_type=='autoRaces'){
            $url = 'https://www.metahorse.site/admin/matches/rewards/autorace';
        }else if($request->update_type=='rankingRaceD1s'){
            $url = 'https://www.metahorse.site/admin/matches/rewards/rankingraced1';
        }else if($request->update_type=='rankingRaceD2s'){
            $url = 'https://www.metahorse.site/admin/matches/rewards/rankingraced2';
        }else if($request->update_type=='rankingRaceD3s'){
            $url = 'https://www.metahorse.site/admin/matches/rewards/rankingraced3';
        }else if($request->update_type=='luckyRaces'){
            $url = 'https://www.metahorse.site/admin/matches/rewards/luckyrace';
        }else if($request->update_type=='superRaces'){
            $url = 'https://www.metahorse.site/admin/matches/rewards/superrace';
        }

        // Collection object

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS,  json_encode($new_array));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.$jwt
          //'Authorization: Bearer '.jwttoken('alice', '0x0E1Bfe045d45C365e1E5ccB754eb8199c6d7C9D3')
        ]);

        $response = curl_exec($ch);

        $dec_response = json_decode($response,1);

        if($dec_response=='true'){
            $notify[] = ['success', 'Updated!'];
            return back()->withNotify($notify);
        }else{
            $notify[] = ['error', 'Not Update!'];
            return back()->withNotify($notify);
        }

        //echo $request->update_type.'<br>';

        //echo $jwt.'<br>';

        //echo json_encode($new_array);

        //return;
    }    

}
