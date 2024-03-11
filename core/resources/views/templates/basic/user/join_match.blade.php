@extends($activeTemplate.'layouts.userfrontend')
@section('content')
    @include($activeTemplate.'partials.breadcrumb')

    @php

      $lang=str_replace(' ', '', session()->get('lang'));

     @endphp

    <section class="bg--section">
        <div class="text-uppercase">
          <div class="match-banner mb-5 mt-2"><a href="#" class="w-100 match-join"><img src="{{url('assets/images/dashboard/'.$lang.'/01.OsakaBanner.png')}}" class="w-100"></a></div>
            <div class="text-white mb-3">
              <p>@lang('My Listed Match') <i class="las la-info round-border" data-toggle="tooltip" title="@lang('MY MATCHES (JOINED BY MY HORSES) IN DAILY SCHEDULE')"></i></p>
            </div>

            <div class="table-responsive">
                      <table class="table table-dark text-center w-md-100">
                        <thead>
                            <tr>
                              <th scope="col">@lang('Location')</th>
                              <th scope="col">@lang('Distance')</th>
                              <th scope="col">@lang('Type')</th>
                              <th scope="col">@lang('Date Time') <i class="las la-info round-border" data-toggle="tooltip" title="MATCH STARTED FROM THE DATETIME"></i></th>
                              <th scope="col">@lang('Countdown') <i class="las la-info round-border" data-toggle="tooltip" title="COUNTDOWN TO MATCH START"></i></th>
                              <th scope="col">@lang('Result')</th>
                              <th scope="col">@lang('Replay')</th>
                            </tr>
                          </thead>
                          <tbody>
                            @forelse ($gdata['daily_match'] as $no => $d_data)
    
                                <tr data-mid="{{$d_data->matchId}}">
                                    <td class="stadium-name">{{$d_data->stadiumName}}</th>
                                    <td>{{$d_data->stadiumDistance}}M</td>
                                    <td>{{$d_data->routeType}}</td>
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

                                      echo '<td class="countdown" data-datetime="'.date('d M Y h:i:s a',$startlive).'" data-endlive="'.date('d M Y h:i:s a',$endlive).'"><div id="days" class="d-inline-block"></div> <div id="hours" class="d-inline-block"></div> <div id="minutes" class="d-inline-block"></div> <div id="seconds" class="d-inline-block">';

                                      echo '</td>';

                                      @endphp
                                    <td>
                                      <button class="btn btn-result px-2 py-3 text-white text-uppercase btn-golden disabled" data-result="3">@lang('View')</button>
                                    </td>
                                    <td>
                                      <button class="btn btn-replay px-2 py-3 text-white text-uppercase btn-golden disabled" data-result="3">@lang('Watch')</button>
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">@lang('No Match Available.')</td>
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
        </div>
    </section>

    <script>
      $(function () {
        $('[data-toggle="tooltip"]').tooltip();

        var modal = '';

        $('.match-join').on('click',function(e){

                e.preventDefault();

                var plink = "{{url('user/verify-match')}}";

                $('<form action="'+plink+'" method="post">@csrf<input type="hidden" name="join" value="1"></form>').appendTo('body').submit();

              });



      });

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

          var lpassed = "@lang('Passed')";

          var llive = "@lang('LIVE')";

          if(willend<=0) {

            $(this).html('<strong class="text-white">'+lpassed+'</strong>');

            $(this).closest('tr').find('button.disabled').removeClass('disabled');

          }else if(timeLeft<=0) {

            $(this).html('<strong class="text-white">'+llive+'</strong>');

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

        var span = document.getElementsByClassName("close")[0];

        $('.btn-result').on('click',function(){

          $(".modal-result .list-data").html("<h5 class='mb-5'>@lang('Result is Processing')</h5>");

          var mid = $(this).closest('tr').data('mid');

          var rcount = $(this).data('result');

          console.log(mid);
          $.ajax({url: "{{url('/user/list-result/')}}?mid="+mid+"&res="+rcount, success: function(result){
              $(".modal-result .list-data").html(result);
            }});

          $('.modal-result').show();


        });


        $('.btn-replay').on('click',function(){

          var mid = $(this).closest('tr').data('mid');

          var sname = $(this).closest('tr').find('.stadium-name').text().trim();

          var rcount = $(this).data('result');

          $('.modal-replay').find('.replay-iframe').html('<h5 class="mb-5">@lang("Result is Processing")</h5>');

          $.ajax({url: "{{url('/user/list-replay/')}}?mid="+mid+"&sname="+sname+"&res="+rcount, success: function(result){
              $('.modal-replay').find('.replay-iframe').html(result);
            }});

          $('.modal-replay').show();


        });

        $('.close').on('click',function(){
          $(this).closest('.modal').hide();
        });

      //    var endTime = new Date("29 April 2018 9:56:00 GMT+01:00");  
             

      }

      setInterval(function() { makeTimer(); }, 1000);
    </script>

@endsection

