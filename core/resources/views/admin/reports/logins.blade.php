@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <!-- <pre> -->
            @php

            //print_r($reward_list);

            @endphp
        <!-- </pre> -->
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">

                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th>@lang('User')</th>
                                <th>@lang('Match Date')</th>
                                <th>@lang('Amount')</th>
                                <th>@lang('Claimed')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($reward_list['rewards']))
                            @forelse($reward_list['rewards'] as $log)
                                <tr>

                                <td data-label="@lang('User')">
                                    <span class="font-weight-bold">{{ $log['username'] }}</span>
                                </td>


                                    <td data-label="@lang('Match Date')">
                                        @php

                                            $tsdate=strtotime($log['matchDate']);

                                            echo date('Y-m-d',$tsdate).'<br>'.diffForHumans(date('Y-m-d',$tsdate));


                                        @endphp
                                    </td>

                            

                                    <td data-label="@lang('Amount')">
                                        <span class="font-weight-bold">
                                        {{$log['g']}} G
                                        </span>
                                    </td>

                                    <td data-label="@lang('Claimed')">
                                        @php

                                            if($log['isTaken']==''){
                                                echo '<span class="font-weight-bold">No</span>';
                                            }else{
                                                echo '<span class="font-weight-bold">Yes</span>';
                                            }

                                        @endphp
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                </tr>
                            @endforelse
                            @else

                            <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                </tr>
                                @endif
                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                
            </div><!-- card end -->
            <div class="pagination">
                    @php

                        if(isset($reward_list['count'])){

                            $total=count($reward_list['rewards']);

                            if($reward_list['count']>0&&$total>0){


                                  $totalpageremain=$reward_list['count']%15;


                                  $totalpage=($reward_list['count']-$totalpageremain)/15;


                                  if($totalpageremain>0){
                                      $totalpage++;
                                  }


                                  $prevno=$page-1;

                                  $nexno=$page+1;


                                  $prev=url('admin/report/reward?page='.$prevno);

                                  $next=url('admin/report/reward?page='.$nexno);

                                  if(isset($_GET['search'])){
                                      $prev=url('admin/report/reward?page='.$prevno.'&&search='.$_GET['search']);

                                      $next=url('admin/report/reward?page='.$nexno.'&search='.$_GET['search']);
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
@endsection



@push('breadcrumb-plugins')
    @if(request()->routeIs('admin.report.reward'))
    <form action="{{ route('admin.report.reward') }}" method="GET" class="form-inline float-sm-right bg--white">
        <div class="input-group has_append mr-2">
            <select name="filter" class="form-control" value="{{ $filter ?? '' }}">
                <option value="">Select Filter</option>
                <option value="taken" @if($filter == "taken")selected @endif>Taken</option>
                <option value="nottaken" @if($filter == "nottaken")selected @endif>Not Taken</option>
            </select>
        </div>
        <div class="input-group has_append">
            <input type="text" name="search" class="form-control" placeholder="@lang('Search Username')" value="{{ $search ?? '' }}">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>
    @endif
@endpush