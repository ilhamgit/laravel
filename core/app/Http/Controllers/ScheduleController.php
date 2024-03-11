<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Events\ActionEvent;
use App\Http\Controllers\QueryController;

class ScheduleController extends Controller
{
   
  public function cron6()
  {
       $id = 6;
       $schedulerLog = 'scheduler_log';
       $innerLog2 = $schedulerLog.'/generate/'.$id;
       mkdir($innerLog2.'/', 0777, true);
       file_put_contents($innerLog2.'/'.date('Y-m-d_H:i:s').'.txt', 'from scheduler');
  }

    
}
