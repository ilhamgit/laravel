@extends($activeTemplate.'layouts.userfrontend')
@section('content')
    @include($activeTemplate.'partials.breadcrumb')

    <!-- <pre class="text-white"> -->
      
      @php

      //print_r($gdata['UGData']);

      @endphp

    <!-- </pre> -->


    <section class="bg--section">
        <div class="text-uppercase">
            <div class="text-white mb-3">
              <p>@lang('Past Results') <i class="las la-info round-border" data-toggle="tooltip" title="@lang('PAST 15 MATCHES HISTORY')"></i></p>
            </div>

            <div class="table-responsive">
                      <table class="table table-dark text-center w-md-100">
                        <thead>
                            <tr>
                              <th scope="col">@lang('Location')</th>
                              <th scope="col">@lang('Distance')</th>
                              <th scope="col">@lang('Type')</th>
                              <th scope="col">@lang('Top 3') <i class="las la-info round-border" data-toggle="tooltip" title="@lang('TOP 3 RANKING IN HORSE NUMBER')"></i></th>
                              <th scope="col">@lang('Date Time') <i class="las la-info round-border" data-toggle="tooltip" title="@lang('MATCH STARTED FROM THE DATETIME')"></i></th>
                              <th scope="col">@lang('Result')</th>
                              <th scope="col">@lang('Replay')</th>
                            </tr>
                          </thead>
                          <tbody>
                            @forelse ($gdata['past_match'] as $no => $d_data)
    
                                <tr data-mid="{{$d_data->matchId}}">
                                    <td class="stadium-name">{{$d_data->stadiumName}}</th>
                                    <td>{{$d_data->stadiumDistance}}M</td>
                                    <td>{{$d_data->routeType}}</td>
                                    <td>
                                      @forelse ($d_data->results as $winner)
                                          <p class="m-1">#{{$winner->playerRanking}} - {{$winner->horseNumber}}</p>
                                      @empty

                                          <p class="m-1">N/A</p>

                                      @endforelse
                                    </td>

                                      @php

                                      $tstamp=strtotime($d_data->betStartDate);

                                      echo '<td data-date="'.date('d F Y h:i:s',$tstamp).' GMT+09:00">';

                                      echo date('l, d M Y h:i a',$tstamp).' (GMT +9)';

                                      echo '</td>';

                                      @endphp

                                    
                                    <td>
                                      <button class="btn btn-result px-2 py-3 text-white text-uppercase btn-golden" data-result="{{count($d_data->results)}}">@lang('View')</button>
                                    </td>
                                    <td><button class="btn btn-replay px-2 py-3 text-white text-uppercase btn-golden" data-result="{{count($d_data->results)}}">@lang('Watch')</button></td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">@lang('No Match Available.')</td>
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
    </section>

    <script>

        // Get the modal

        $(document).ready(function(){
          $('[data-toggle="tooltip"]').tooltip();
        });

        var modal = '';

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

        
    </script>

@endsection

