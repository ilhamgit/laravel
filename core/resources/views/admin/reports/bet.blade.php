@extends('admin.layouts.app')

@section('panel')

    <div class="row">
        <!-- <pre> -->
        @php

            //print_r($bets_list);

        @endphp
        <!-- </pre> -->
        <div class="col-lg-12 col-md-12 mb-30">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('User')</th>
                                    <th>@lang('Bet')</th>
                                    <th>@lang('Win')</th>
                                </tr>
                            </thead>

                            <tbody class="list">

                                @forelse ($bets_list['logs'] as $item)

                                    <tr>
                                        <td data-label="@lang('User')">{{$item['username']}}</td>
                                        <td data-label="@lang('Bet')">{{$item['totalBets']}}</td>
                                        <td data-label="@lang('Win')">{{$item['totalWins']}}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="100%">{{__($emptyMessage)}}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="pagination">
                    @php

                        if(isset($bets_list['count'])){

                            $total=count($bets_list['logs']);

                            if($bets_list['count']>50&&$total>0){

                                  $totalpageremain=$bets_list['count']%15;


                                  $totalpage=($bets_list['count']-$totalpageremain)/15;

                                  if($totalpageremain>0){
                                      $totalpage++;
                                  }

                                  $prevno=$page-1;

                                  $nexno=$page+1;


                                  $prev=url('admin/report/bet-report?page='.$prevno);

                                  $next=url('admin/report/bet-report?page='.$nexno);

                                  if(isset($_GET['search'])){
                                      $prev=url('admin/report/bet-report?page='.$prevno.'&&search='.$_GET['search']);

                                      $next=url('admin/report/bet-report?page='.$nexno.'&search='.$_GET['search']);
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
        <form action="{{ route('admin.report.bet.search') }}" method="GET" class="form-inline float-sm-right bg--white mt-2">
            <div class="input-group has_append">
                <input type="text" name="search" class="form-control" placeholder="@lang('By User')" value="{{ request()->search??null }}">
                <div class="input-group-append">
                    <button class="btn btn--primary" type="submit"><i class="las la-search"></i></button>
                </div>
            </div>
        </form>
    @endpush
@endsection
