@extends($activeTemplate.'layouts.userfrontend')
@section('content')
    @include($activeTemplate.'partials.breadcrumb')

    <!-- <pre class="text-white"> -->
     @php

      //print_r($gdata['current_match']);

      $lang=str_replace(' ', '', session()->get('lang'));

     @endphp
    <!-- </pre> -->


    <section class="bg--section">
        <div class="text-uppercase">
          <div class="mb-5"><a href="{{url('user/match-results')}}" class="w-100 match-join"><img src="{{url('assets/images/match/ViewPastResults('.$lang.').png')}}" class="w-100"></a></div>
            <div class="text-white mb-3">
              <p>@lang('UPCOMING MATCHES') <i class="las la-info round-border" data-toggle="tooltip" title="@lang('DISPLAY ALL MATCHES IN DAILY.')"></i></p>
            </div>

            <div class="table-responsive">
                      <table class="table table-dark text-center w-md-100">
                        <thead>
                            <tr>
                              <th scope="col">@lang('Location')</th>
                              <th scope="col">@lang('Distance')</th>
                              <th scope="col">@lang('Date Time') <i class="las la-info round-border" data-toggle="tooltip" title="@lang('MATCH STARTED FROM THE DATETIME.')"></i></th>
                              <th scope="col">@lang('Countdown') <i class="las la-info round-border" data-toggle="tooltip" title="@lang('COUNTDOWN TO MATCH START')"></i></th>
                              <th scope="col"></th>
                            </tr>
                          </thead>
                          <tbody>
                            @forelse ($gdata['current_match']['matches'] as $no => $d_data)
    
                                <tr data-mid="{{$d_data->matchId}}">
                                    <td>{{$d_data->stadiumName}}</th>
                                    <td>{{$d_data->stadiumDistance}}M</td>

                                      @php

                                        $offset=9*60*60;

                                        // get the local timezone
                                        $loc = (new DateTime)->getTimezone();

                                        $tstamp=strtotime($d_data->betStartDate);

                                        $slt = new DateTime($d_data->betStartDate, new DateTimeZone('UTC'));

                                        // change the timezone of the object without changing its time
                                        $slt->setTimezone($loc);


                                        $startlive=strtotime($slt->format('Y-m-d H:i:s T'));

                                        $startlive=$startlive-$offset;



                                        $elt = new DateTime($d_data->betEndDate, new DateTimeZone('UTC'));

                                        // change the timezone of the object without changing its time
                                        $elt->setTimezone($loc);


                                        $endlive=strtotime($elt->format('Y-m-d H:i:s T'));
                                        $endlive=$endlive-$offset;


                                        echo '<td real-date="'.$d_data->betStartDate.'" real-end-date="'.$d_data->betEndDate.'" data-date="'.date('d F Y h:i:s',$tstamp).' GMT+09:00">';
                                        echo date('l, d M Y h:i a',$tstamp).' (GMT +9)';
                                        echo '</td>';
                                        echo '<td class="countdown" data-datetime="'.date('d M Y h:i:s a',$startlive).'" data-endlive="'.date('d M Y h:i:s a',$endlive).'">';
                                        echo '  <div id="days" class="d-inline-block"></div> <div id="hours" class="d-inline-block"></div> <div id="minutes" class="d-inline-block"></div> <div id="seconds" class="d-inline-block"></div>
                                              </td>';

                                      @endphp
                                    <td>
                                      <a href="{{ route('user.match-bet', $d_data->matchId) }}" class="btn btn-result px-2 py-3 text-white text-uppercase btn-golden disabled">
                                        @lang('Play')
                                      </a>
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">@lang('No Match Available.')</td>
                                </tr>

                            @endforelse
                          </tbody>
                      </table>

                      
                      <div class="modal modal-result">

                                        <!-- Modal content -->
                                        <div class="modal-content text-center">
                                          <span class="close mb-2">&times;</span>
                                          
                                          <div class="list-data"></div>

                                        </div>

                                      </div>
                    </div>

                    <div class="modal modal-replay">

                                      <!-- Modal content -->
                                      <div class="modal-content text-center">
                                        <span class="close mb-2">&times;</span>

                                        <div class="embed-responsive embed-responsive-16by9 replay-iframe">
                                        </div>

                                      </div>

                                    </div>
                    </div>

                    @php

                    if($gdata['current_match']['matchCount']>0){

                      $prevno=$pgnum-1;

                      $nexno=$pgnum+1;

                      $prev=url('/user/place-bet/?pgnum='.$prevno);

                      $next=url('/user/place-bet/?pgnum='.$nexno);

                      @endphp

                      <div class="row">
                        <div class="col-4 text-white text-right">
                          @if ($pgnum > 0)
                          <a href="{{$prev}}" class="btn btn-result px-2 py-3 text-white text-uppercase">
                                        <i class="las la-chevron-left"></i>
                                      </a>
                          @endif
                        </div>
                        <div class="col-4 text-white text-center px-2 py-3">{{$pgnum+1}} / {{$gdata['current_match']['matchCount']}}</div>
                        <div class="col-4 text-white text-left">
                          @if ($pgnum < $gdata['current_match']['matchCount'])
                          <a href="{{$next}}" class="btn btn-result px-2 py-3 text-white text-uppercase">
                                        <i class="las la-chevron-right"></i>
                                      </a>
                          </div>
                          @endif
                      </div>

                      @php

                    }

                    @endphp

        </div>

    </section>

    <script>

        // Get the modal

        $(document).ready(function(){
          $('[data-toggle="tooltip"]').tooltip();
        });

        var modal = '';

        var span = document.getElementsByClassName("close")[0];

        $('.btn-result').on('click',function(){

          $nop = $(this).attr('resno');

          var modal = $('#result-'+$nop).attr('id');

          $('#result-'+$nop).show();


        });


        $('.btn-replay').on('click',function(){

          $nop = $(this).attr('repno');

          var modal = $('#replay-'+$nop).attr('id');

          $('#replay-'+$nop).show();


        });

        $('.close').on('click',function(){
          $(this).closest('.modal').hide();
        });


        var passed = false;

        function makeTimer(e) {

        $('.countdown').each(function(){

          var gdate=$(this).data('datetime');

          var eldate=$(this).attr('data-endlive');

          var endTime = new Date(gdate);      
          endTime = (Date.parse(endTime) / 1000);

          var endLive = new Date(eldate);      
          endLive = (Date.parse(endLive) / 1000);

          var now = new Date();
          now = (Date.parse(now) / 1000);

          var timeLeft = endTime - now;

          var willend = endLive - now;

          var days = Math.floor(timeLeft / 86400); 
          var hours = Math.floor((timeLeft - (days * 86400)) / 3600);
          var minutes = Math.floor((timeLeft - (days * 86400) - (hours * 3600 )) / 60);
          var seconds = Math.floor((timeLeft - (days * 86400) - (hours * 3600) - (minutes * 60)));

          if(willend<=0) {
            if(! passed){
              passed=true;
              window.location.reload();
            }

            

          }else if(timeLeft<=0) {

            $(this).html('<strong class="text-white">@lang("LIVE")</strong>');
            $(this).closest('tr').find('a.disabled').removeClass('disabled');

            $(this).attr('data-endlivesec',willend);

          }else{
            if (hours < "10") { hours = "0" + hours; }
            if (minutes < "10") { minutes = "0" + minutes; }
            if (seconds < "10") { seconds = "0" + seconds; }

            $(this).find("#days").html(days + "<span>D</span>");
            $(this).find("#hours").html(hours + "<span>H</span>");
            $(this).find("#minutes").html(minutes + "<span>M</span>");
            $(this).find("#seconds").html(seconds + "<span>S</span>");
            $(this).attr('data-timeleft',timeLeft);

            $(this).attr('data-endlivesec',willend);
          }
      

        });

      //    var endTime = new Date("29 April 2018 9:56:00 GMT+01:00");  
             

      }

      setInterval(function() { makeTimer(); }, 1000);


      // function checkpass(c) {

      //   if(passed>0){

      //   }

      // }

      // setInterval(function() { checkpass(); }, 5000);

        
    </script>


@endsection

