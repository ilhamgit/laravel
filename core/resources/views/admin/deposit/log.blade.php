@extends('admin.layouts.app')

@section('panel')

<!-- <pre> -->
    @php

    $success=0;

    $pending=0;

    $error=0;

    //print_r($dep_list);

    foreach($dep_list['pending'] as $no => $d_data){
        $pending+=$d_data['value'];
    }

    foreach($dep_list['confirmed'] as $no => $d_data){
        if($d_data['status']=='success'){
            $success+=$d_data['value'];
        }else{
            $error+=$d_data['value'];
        }
    }


    @endphp
<!-- </pre> -->

<div class="row justify-content-center">
    @if(request()->routeIs('admin.deposit.list') || request()->routeIs('admin.deposit.method') || request()->routeIs('admin.users.deposits') || request()->routeIs('admin.users.deposits.method'))
        <div class="col-md-4 col-sm-6 mb-30">
            <div class="widget-two box--shadow2 b-radius--5 bg--success">
            <div class="widget-two__content">
                <h2 class="text-white">{{$success}} MTBTC</h2>
                <p class="text-white">@lang('Successful Deposit')</p>
            </div>
            </div><!-- widget-two end -->
        </div>
        <div class="col-md-4 col-sm-6 mb-30">
            <div class="widget-two box--shadow2 b-radius--5 bg--6">
                <div class="widget-two__content">
                    <h2 class="text-white">{{$pending}} MTBTC</h2>
                    <p class="text-white">@lang('Pending Deposit')</p>
                </div>
            </div><!-- widget-two end -->
        </div>
        <div class="col-md-4 col-sm-6 mb-30">
            <div class="widget-two box--shadow2 b-radius--5 bg--pink">
            <div class="widget-two__content">
                <h2 class="text-white">{{$error}} MTBTC</h2>
                <p class="text-white">@lang('Rejected Deposit')</p>
            </div>
            </div><!-- widget-two end -->
        </div>
    @endif

    <div class="col-md-12">
        <div class="card b-radius--10">
            <div class="card-body p-0">
                <div class="table-responsive--sm table-responsive">
                    <table class="table table--light style--two">
                        <thead>
                        <tr>
                            <th>@lang('ID')</th>
                            <th>Log ID</th>
                            <th>@lang('Initiated')</th>
                            <th>@lang('User')</th>
                            <th>@lang('Amount')</th>
                            <th>@lang('Action Type')</th>
                            <th>@lang('Status')</th>
                        </tr>
                        </thead>
                        <tbody>

                            @php

                            if(isset($dep_list['count'])){


                                if(count($dep_list['pending'])>0||count($dep_list['confirmed'])>0){

                                    $noid=1;

                                    if($page>1){
                                        $noid+=($page-1)*15;
                                    }

                                    foreach($dep_list['pending'] as $no => $d_data){


                                        $timestamp=strtotime($d_data['createdDate']);


                                        echo '

                                        <tr>
                                            <td>
                                                <span class="font-weight-bold">
                                                    '.$noid.'
                                                </span>
                                            </td>
                                            <td>'.$d_data['logId'].'</td>
                                            <td>
                                                '.date('Y-m-d h:i a',$timestamp).'
                                            </td>
                                            <td>
                                                <span class="font-weight-bold">'.$d_data['username'].'</span>
                                            </td>
                                            <td>
                                                <span class="font-weight-bold">'.$d_data['value'].' MTBTC</span>
                                            </td>
                                            <td>
                                                <span class="font-weight-bold">'.$d_data['actionType'].'</span>
                                            </td>
                                            <td>
                                                <span class="font-weight-bold">'.$d_data['status'].'</span>
                                            </td>
                                        </tr>


                                        ';

                                        $noid++;


                                    }

                                    foreach($dep_list['confirmed'] as $no => $d_data){


                                        $timestamp=strtotime($d_data['createdDate']);


                                        echo '

                                        <tr>
                                            <td>
                                                <span class="font-weight-bold">
                                                    '.$noid.'
                                                </span>
                                            </td>
                                            <td>'.$d_data['logId'].'</td>
                                            <td>
                                                '.date('Y-m-d h:1 a',$timestamp).'
                                            </td>
                                            <td>
                                                <span class="font-weight-bold">'.$d_data['username'].'</span>
                                            </td>
                                            <td>
                                                <span class="font-weight-bold">'.$d_data['value'].' G</span>
                                            </td>
                                            <td>
                                                <span class="font-weight-bold">'.$d_data['actionType'].'</span>
                                            </td>
                                            <td>
                                                <span class="font-weight-bold">'.$d_data['status'].'</span>
                                            </td>
                                        </tr>


                                        ';

                                        $noid++;

                                    }



                                }else{
                                    echo'

                                        <tr>
                                            <td class="text-muted text-center" colspan="100%">'.$emptyMessage.'</td>
                                        </tr>


                                    ';
                                }


                            }else{

                                echo'

                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">'.$dep_list['message'].'</td>
                                    </tr>


                                ';

                            }

                            @endphp

                            
                        </tbody>
                    </table><!-- table end -->
                </div>
            </div>

        </div><!-- card end -->

        <div class="pagination">
                    @php

                        if(isset($dep_list['count'])){

                            $total=count($dep_list['pending'])+count($dep_list['confirmed']);

                            if($dep_list['count']>0){


                                  $totalpageremain=$dep_list['count']%15;


                                  $totalpage=($dep_list['count']-$totalpageremain)/15;

                                  if($totalpageremain>0){
                                      $totalpage++;
                                  }


                                  $end=explode('?',end($uri));

                                  $prevno=$page-1;

                                  $nexno=$page+1;

                                  //echo $end[0];

                                  switch ($end[0]) {
                                        case 'rejected':
                                            $prev=url('admin/deposit/rejected/?page='.$prevno);

                                            $next=url('admin/deposit/rejected/?page='.$nexno);
                                            break;

                                        case 'successful':
                                            $prev=url('admin/deposit/successful/?page='.$prevno);

                                            $next=url('admin/deposit/successful/?page='.$nexno);
                                            break;

                                        case 'pending':
                                            $prev=url('admin/deposit/pending/?page='.$prevno);

                                            $next=url('admin/deposit/pending/?page='.$nexno);
                                            break;
                                        
                                        default:
                                            $prev=url('admin/deposit/?page='.$prevno);

                                            $next=url('admin/deposit/?page='.$nexno);
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


@endsection


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


@push('script-lib')
  <script src="{{ asset('assets/admin/js/vendor/datepicker.min.js') }}"></script>
  <script src="{{ asset('assets/admin/js/vendor/datepicker.en.js') }}"></script>
@endpush
@push('script')
  <script>
    (function($){
        "use strict";
        if(!$('.datepicker-here').val()){
            $('.datepicker-here').datepicker();
        }
    })(jQuery)
  </script>
@endpush
