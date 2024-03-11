@extends('admin.layouts.app')

@section('panel')
<!--     <pre> -->
    @php
//print_r($bets_list);

//echo $bets_url;
    @endphp
<!-- </pre> -->
    <div class="row">
        <div class="col-lg-12 col-md-12 mb-30">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Match ID')</th>
                                    <th>@lang('Stadium')</th>
                                    <th>@lang('Distance')</th>
                                    <th>@lang('Type')</th>
                                    <th>@lang('Start At | End At')</th>
                                    <th>@lang('Bet')</th>
                                    <th>@lang('Win')</th>
                                    <th>@lang('Status')</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @forelse ($bets_list['logs'] as $item)
                                    @php

                                    $stimestamp=strtotime($item['betStartDate']);

                                    $etimestamp=strtotime($item['betEndDate']);


                                    @endphp
                                    <tr>
                                        <td data-label="@lang('User')">
                                            <span class="font-weight-bold">{{__($item['matchId'])}}</span>
                                        </td>
                                        <td data-label="@lang('Stadium')">{{__($item['stadiumName'])}}</td>
                                        <td data-label="@lang('Distance')">{{__($item['stadiumDistance'])}}</td>
                                        <td data-label="@lang('Type')"><span class="text--primary">{{__($item['routeType'])}}</span></td>
                                        <td data-label="@lang('Start At | End At')">@php echo date('Y-m-d h:i a',$stimestamp); @endphp<br>@php echo date('Y-m-d h:i a',$etimestamp); @endphp</td>
                                        <td data-label="@lang('Bet')"><span class="text--primary">{{$item['totalBets']}}</span></td>
                                        <td data-label="@lang('Win')"><span class="text--primary">{{$item['totalWins']}}</span></td>
                                        <td data-label="@lang('Status')">
                                           @php 

                                            if($item['isProcessed']==1){
                                                echo 'In Progress';
                                            }else{
                                                echo 'Pending';
                                            }

                                           @endphp
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{__($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="pagination">
                    @php

                        if(isset($bets_list['count'])){

                            $total=count($bets_list['logs']);

                            if($bets_list['count']>15&&$total>0){

                                  $totalpageremain=$bets_list['count']%15;


                                  $totalpage=($bets_list['count']-$totalpageremain)/15;

                                  if($totalpageremain>0){
                                      $totalpage++;
                                  }

                                  $prevno=$page-1;

                                  $nexno=$page+1;


                                  $prev=url('admin/bets/all?page='.$prevno);

                                  $next=url('admin/bets/all?page='.$nexno);

                                  if(isset($_GET['date'])){
                                        $prev.='&d='.$_GET['date'];
                                        $next.='&d='.$_GET['date'];
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
    </div>

    @push('breadcrumb-plugins')
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

        <form method="GET" class="form-inline float-sm-right bg--white">
            <div class="input-group has_append">
                <input type="date" name="date" class="form-control" value="{{ request()->date??null }}">
                <div class="input-group-append">
                    <button class="btn btn--primary" type="submit"><i class="las la-search"></i></button>
                </div>
            </div>
        </form>
    @endpush
@endsection
