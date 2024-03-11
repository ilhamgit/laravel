<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\League;
use Illuminate\Http\Request;
use App\Models\Match;

class MatchController extends Controller
{
    protected $pageTitle;
    protected $emptyMessage;

    protected function filterMatches($type){

        $matches = Match::latest();
        $this->pageTitle    = ucfirst($type). ' Matches';
        $this->emptyMessage = "No $type match found";

        if($type != 'all'){
            $matches = $matches->$type();
        }

        if(request()->search){
            $search             = request()->search;
            $matches            = $matches->where('name', 'like',"%$search%");
            $this->pageTitle    = "Search Result for '$search'";
        }

        return $matches->with(['category','league', 'questions'])->paginate(getPaginate());
    }

    public function index()
    {
        include 'AdminJWT.php';

        $segments       = request()->segments();
        $type           = end($segments);
        $matches        = $this->filterMatches(end($segments));
        $leagues        = League::latest()->get();
        $pageTitle      = $this->pageTitle;
        $emptyMessage   = $this->emptyMessage;

        $token = generateToken();
        $jwt = generateJwt($token);

        $uri=explode('/',$_SERVER['REQUEST_URI']);

        $page=0;

        if(isset($_GET['page'])){
            $page=$_GET['page']-1;
        }

        $mud_url="";

        switch (end($uri)) {
            case 'running':
                $mud_url="https://www.metahorse.site/admin/matches/running/".$page;
                break;

            case 'upcoming':
                $mud_url="https://www.metahorse.site/admin/matches/upcoming/".$page;
                break;

            case 'completed':
                $mud_url="https://www.metahorse.site/admin/matches/completed/".$page;
                break;
            
            default:
                $mud_url="https://www.metahorse.site/admin/matches/".$page;
                break;
        }


        $page++;

        if(isset($_GET['date'])){
            $mud_url.='?d='.$_GET['date'];
        }
        
        $ch = curl_init($mud_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Bearer '.$jwt
          //'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ0b2tlbmtleSI6ImpqRW5qUDg3XC9HOGZ5NEIwRFo3azhMK25ETkNmOGR5VkZ5M2thWm54bFNxcUJOOEdWRjBCRTlvcVdBZXU1R1wvU2dIZ2d0THFXc2hVUUd5MVgySndST0pVM3FQa1hXYVUzbTdITk5oXC9yVlJnPSIsImp0aSI6IjkzRUQxQzU0LTk1NjctNDY3Ny1BODJCLTdFQUE4NEQ1NkJFOSIsIm5iZiI6MTY2MzQ5ODA4MCwiZXhwIjoxNjYzNDk4OTgwLCJpYXQiOjE2NjM0OTgwODAsImlzcyI6Ik1ldGFob3JzZUlzc3VlciIsImF1ZCI6Ik1ldGFob3JzZUF1ZGllbmNlIn0.yHRxlhc1-bzqTkmpR8XsRKKOrHkvQL7eO2YXVY_kPeo'
        ]);
        
        $mud_response = curl_exec($ch);

        $match_list=json_decode($mud_response,1);

        $path=url()->current();

        return view('admin.match.index',compact('pageTitle', 'matches', 'emptyMessage', 'leagues', 'jwt', 'mud_response', 'match_list', 'path', 'page','jwt'));
    }

    public function store(Request $request, $id=0)
    {
        $request->validate([
            'name'              => 'required',
            'league_id'         => 'required|integer|gt:0',
            'beginning_time'    => 'required|date_format:Y-m-d h:i a',
            'finishing_time'    => 'required|date_format:Y-m-d h:i a|after:start_time'
        ]);

        $league = League::findOrFail($request->league_id);

        if($id){
            $match = Match::findOrFail($id);
            $notification = 'Match updated successfully';
            $match->status = $request->status ? 1 : 0;
        }else{
            $match = new Match();
            $notification = 'Match added successfully';
        }

        $match->name        = $request->name;
        $match->category_id = $league->category->id;
        $match->league_id   = $league->id;
        $match->start_time  = $request->beginning_time;
        $match->end_time    = $request->finishing_time;
        $match->save();

        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }
}
