<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bet;
use Illuminate\Http\Request;

include 'AdminJWT.php';

class BetsController extends Controller
{
    protected $pageTitle;
    protected $emptyMessage;

    protected function filterBets($type){
        $bets               = Bet::latest();
        $this->pageTitle    = ucfirst($type). ' Bets';

        if(ucfirst($type)=='Won'){
            $this->pageTitle    = 'Processed Bets';
        }else if(ucfirst($type)=='Pending'){
            $this->pageTitle    = 'Not Processed Bets';
        }

        $this->emptyMessage = "No $type bet found";

        if($type != 'all'){
            $bets = $bets->$type();
        }

        if(request()->search){
            $search  = request()->search;
            $bets    = $bets->whereHas('user', function ($user) use ($search) {
                            $user->where('username', 'like',"%$search%");
                        })->orWhereHas('question', function ($question) use ($search) {
                            $question->where('name', 'like',"%$search%");
                        })->orWhereHas('question.match', function ($question) use ($search) {
                            $question->where('name', 'like',"%$search%");
                        });

            $this->pageTitle    = "Search Result for '$search'";
        }

        return $bets->with(['user','match','question','option'])->paginate(getPaginate());
    }

    public function index()
    {
        $segments       = request()->segments();
        $type           = end($segments);
        $bets           = $this->filterBets(end($segments));
        $pageTitle      = $this->pageTitle;
        $emptyMessage   = $this->emptyMessage;

        //newapi

        $uri=explode('/',$_SERVER['REQUEST_URI']);

        $token = generateToken();
        $jwt = generateJwt($token);

        $page=0;


        if(isset($_GET['page'])){
            $page=$_GET['page']-1;
        }
        
        
        $bets_url="https://www.metahorse.site/admin/matches/bets/".$page;

        if(end($uri)=='won'){
            $bets_url="https://www.metahorse.site/admin/matches/bets/processed/".$page;
        }else if(end($uri)=='pending'){
            $bets_url="https://www.metahorse.site/admin/matches/bets/notprocessed/".$page;
        }

        if(isset($_GET['date'])){
            $bets_url.='?d='.$_GET['date'];
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

        return view('admin.bet.index',compact('pageTitle', 'bets', 'emptyMessage','bets_list', 'page', 'bets_url', 'uri'));
    }

    public function search(Request $request)
    {
        $search = $request->search;
        $pageTitle = 'Bet Search - ' . $search;
        $emptyMessage = 'No bet found';

        $bets = Bet::whereHas('user', function ($user) use ($search) {
            $user->where('username', 'like',"%$search%");
        })->orWhereHas('question', function ($question) use ($search) {
            $question->where('name', 'like',"%$search%");
        })->with(['user','match','question','option'])
        ->latest()
        ->paginate(getPaginate());

        return view('admin.bet.index',compact('pageTitle', 'bets', 'emptyMessage', 'search'));
    }

}
