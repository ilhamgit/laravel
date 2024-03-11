@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--lg table-responsive">
                        @php

                        $uri=explode('/',$_SERVER['REQUEST_URI']);

                        //print_r($uri);

                        //echo '<br>';

                        //echo '<pre>';
                        //print_r($match_list);
                        //echo '</pre>';

                        @endphp
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('SL')</th>
                                    <th>@lang('Stadium Name') | @lang('Distance')</th>
                                    <th>@lang('Route Type')</th>
                                    <th>@lang('Start At') | @lang('End At')</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @php

                                if (isset($match_list['matches'])){

                                @endphp

                                    @forelse ($match_list['matches'] as $no => $item)

                                        @php
                                        
                                            $pg_mul=15*($page-1);

                                        @endphp

                                        <tr>
                                            <td data-label="@lang('SL')">@php echo $no+1+$pg_mul; @endphp</td>
                                            <td data-label="@lang('Stadium Name / Distance')">
                                                <span class="font-weight-bold">{{$item['stadiumName']}}</span>
                                                <br>
                                                {{$item['stadiumDistance']}}
                                            </td>
                                            <td data-label="@lang('Route Type')">{{$item['routeType']}}</td>
                                            <td data-label="@lang('Start Time')">
                                                @php

                                                    $start=date('d M Y, h:i A',strtotime($item['betStartDate']));

                                                    $end=date('d M Y, h:i A',strtotime($item['betEndDate']));

                                                @endphp
                                                <span class="d-block font-weight-bold">{{$start}}</span>
                                                <span class="font-weight-bold">{{$end}}</span>
                                            </td>



                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="text-muted text-center" colspan="100%">{{__('Match Not Available') }}</td>
                                        </tr>
                                    @endforelse

                                @php

                                }else{

                                @endphp
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{__($match_list['message']) }}</td>
                                    </tr>

                                @php
                                }
                                @endphp
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>

            <div class="pagination">
                    @php

                        if(isset($match_list['matchCount'])){

                            if($match_list['matchCount']>0){

                                  $totalpageremain=$match_list['matchCount']%15;


                                  $totalpage=($match_list['matchCount']-$totalpageremain)/15;

                                  if($totalpageremain>0){
                                      $totalpage++;
                                  }

                                  $prevno=$page-1;

                                  $nexno=$page+1;

                                  switch (end($uri)) {
                                        case 'running':
                                            $prev=url('admin/match/running/?page='.$prevno);

                                            $next=url('admin/match/running/?page='.$nexno);
                                            break;

                                        case 'upcoming':
                                            $prev=url('admin/match/upcoming/?page='.$prevno);

                                            $next=url('admin/match/upcoming/?page='.$nexno);
                                            break;

                                        case 'completed':
                                            $prev=url('admin/match/completed/?page='.$prevno);

                                            $next=url('admin/match/completed/?page='.$nexno);
                                            break;
                                        
                                        default:
                                            $prev=url('admin/matches/all/?page='.$prevno);

                                            $next=url('admin/matches/all/?page='.$nexno);
                                            break;
                                    }

                                    if(isset($_GET['date'])){
                                        $prev.='&date='.$_GET['date'];
                                        $next.='&date='.$_GET['date'];
                                    }


                                  @endphp

                                      @if ($page > 1)
                                      <a href="{{$prev}}" class="btn px-2 py-3 text-uppercase ml-auto">
                                                    <i class="las la-chevron-left"></i> PREVIOUS
                                                  </a>
                                      @endif
                                      <span class="px-2 py-3 text-uppercase mx-auto">{{$page}} / {{$totalpage}}</span>
                                      @if ($page < $totalpage)
                                      <a href="{{$next}}" class="btn px-2 py-3 text-uppercase mr-auto">
                                                    NEXT <i class="las la-chevron-right"></i>
                                                  </a>
                                      @endif

                                  @php

                                }

                        }

                        


                    @endphp
                    </div>

        </div>
    </div>

    @push('breadcrumb-plugins')
    <div class="d-flex flex-wrap justify-content-end flex-gap-8">

        @php

        if(isset($_GET['date'])){

        @endphp

        <button class="btn btn--primary reset-date mr-2" type="button">Reset</button>

        <script>
          
          $('.reset-date').on('click',function(){

            window.location = window.location.href.split("?")[0];

          });

        </script>

        @php


        }

        @endphp

        <form action="" method="GET" class="form-inline float-sm-right bg--white">
            <div class="input-group has_append">
                <input type="date" name="date" class="form-control" placeholder="@lang('Match Date')" value="{{ request()->date??null }}">
                <div class="input-group-append">
                    <button class="btn btn--primary" type="submit"><i class="las la-search"></i></button>
                </div>
            </div>
        </form>
    </div>
    @endpush
@endsection

@push('script-lib')
    <script src="{{ asset('assets/admin/js/moment-with-local.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/vendor/datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/vendor/datepicker.en.js') }}"></script>
@endpush

@push('script')
<script>

    (function ($) {
        'use strict';
        var start = new Date(),
        prevDay,
        startHours = 12;

        start.setHours(12);
        start.setMinutes(0);

        if ([6, 0].indexOf(start.getDay()) != -1) {
            start.setHours(12);
            startHours = 12
        }

        $('.timepicker').datepicker({
            timepicker: true,
            language: 'en',
            startDate: start,
            minHours: startHours,
            maxHours: 24,
            dateFormat: 'yyyy-mm-dd',

            onSelect: function (fd, d, picker) {

                if (!d) return;

                var day = d.getDay();
                if (prevDay != undefined && prevDay == day) return;
                prevDay = day;

                if (day == 6 || day == 0) {
                    picker.update({
                        minHours: 24,
                        maxHours: 24
                    })
                } else {
                    picker.update({
                        minHours: 24,
                        maxHours: 24
                    })
                }
            }
        });
    })(jQuery);

</script>
@endpush


@push('style')
<style>
    .datepicker{
        z-index: 9999;
    }
</style>
@endpush
