@extends('admin.layouts.app')

@section('panel')
<div class="row">
    <pre>
        @php
        //echo $trn_url.' - '.$linkno;
            //print_r($trans_list);

        if($searchby=='logid'){
            $trans_list['logs']=$trans_list;
        }


        @endphp
    </pre>
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div class="table-responsive--sm table-responsive">
                    <table class="table table--light style--two">
                        <thead>
                            <tr>
                                <th>@lang('User')</th>
                                <th>Log ID</th>
                                <th>@lang('Initiate')</th>
                                <th>@lang('Amount')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Detail')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($trans_list['logs'] as $trans_data)
                            <tr>
                                <td data-label="@lang('User')">
                                    <span class="font-weight-bold">{{ $trans_data['username'] }}</span>
                                    
                                </td>
                                <td data-label="@lang('User')">
                                    {{ $trans_data['logId'] }}
                                <td data-label="@lang('Transacted')">
                                    @php

                                        $tsdate=strtotime($trans_data['createdDate']);

                                        echo date('Y-m-d h:i a',$tsdate).'<br>'.diffForHumans(date('Y-m-d h:i a',$tsdate));


                                    @endphp
                                </td>

                                <td data-label="@lang('Amount')" class="budget">
                                    <span class="font-weight-bold">
                                        {{$trans_data['value']}} G
                                    </span>
                                </td>

                                <td data-label="@lang('Status')" class="budget">

                                    @php

                                    $tcolor='text-info';

                                    switch ($trans_data['status']){

                                        case 'pending':
                                            $tcolor='text-warning';
                                            break;

                                        case 'success':
                                            $tcolor='text-success';
                                            break;

                                        case 'expired':
                                            $tcolor='text-secondary';
                                            break;

                                        case 'cancelled':
                                            $tcolor='text-danger';
                                            break;

                                        case 'error':
                                            $tcolor='text-danger';
                                            break;

                                    } 

                                    @endphp

                                    <span class="font-weight-bold {{$tcolor}}">
                                        {{$trans_data['status']}}
                                    </span>


                               <td data-label="@lang('Detail')" class="text-capitalize">

                                    @php

                                    echo implode(" ", explode("_",$trans_data['actionType']));

                                    @endphp

                                </td>
                           </tr>
                           @empty
                           <tr>
                            <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                        </tr>
                        @endforelse

                    </tbody>
                </table><!-- table end -->
            </div>
        </div>
    </div><!-- card end -->
    <div class="pagination">
                    @php

                        if(isset($trans_list['count'])){

                            if($trans_list['count']>0){

                                $totalpageremain=$trans_list['count']%15;


                                  $totalpage=($trans_list['count']-$totalpageremain)/15;

                                  if($totalpageremain>0){
                                      $totalpage++;
                                  }



                                  $prevno=$page-1;

                                  $nexno=$page+1;

                                  //echo $end[0];

                                  $prev=url('admin/report/transaction/?page='.$prevno);

                                   $next=url('admin/report/transaction/?page='.$nexno);

                                   if(isset($_GET['searchby'])){
                                        $prev.='&searchby='.$_GET['searchby'];
                                        $next.='&searchby='.$_GET['searchby'];
                                    }

                                    if(isset($_GET['logid'])){
                                        $prev.='&search='.$_GET['logid'];
                                        $next.='&search='.$_GET['logid'];
                                    }


                                    if(isset($_GET['filter'])){
                                        $prev.='&filter='.$_GET['filter'];
                                        $next.='&filter='.$_GET['filter'];
                                    }

                                    if(isset($_GET['search'])){
                                        $prev.='&search='.$_GET['search'];
                                        $next.='&search='.$_GET['search'];
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

<form action="{{ route('admin.report.transaction.search') }}" method="GET" class="form-inline float-sm-right">
    <div class="input-group has_append">
        <label for="searchby" class="mr-2">Search By:</label>
        <select name="searchby" class="form-control mr-2">
            <option value="status" @if($searchby == "status")selected @endif>Status</option>
            <option value="username" @if($searchby == "username")selected @endif>Username</option>
            <option value="statususername" @if($searchby == "statususername")selected @endif>Status + Username</option>
            <option value="logid" @if($searchby == "logid")selected @endif>Log ID</option>
        </select>
    </div>
    <div class="input-group has_append">
        <select name="filter" class="form-control mr-2" required>
            <option value="pending" @if($filter == "pending")selected @endif>Pending</option>
            <option value="success" @if($filter == "success")selected @endif>Success</option>
            <option value="expired" @if($filter == "expired")selected @endif>Expired</option>
            <option value="cancelled" @if($filter == "cancelled")selected @endif>Cancelled</option>
            <option value="error" @if($filter == "error")selected @endif>Error</option>
        </select>
    </div>
    <div class="input-group has_append">
        <input type="text" name="logid" class="form-control rounded mr-2 bg--white" placeholder="@lang('Log ID')" value="{{ $logid ?? '' }}" style="display:none" disabled>
        <input type="text" name="search" class="form-control rounded mr-2 bg--white" placeholder="@lang('Username')" value="{{ $search ?? '' }}" style="display:none" disabled>
        <div class="input-group-append">
            <button class="btn btn--primary rounded" type="submit"><i class="fa fa-search"></i></button>
        </div>
    </div>
</form>

<script>

    $(document).ready(function(){

        var searchby = $('select[name=searchby]').val();
        var username = @php if(isset($_GET['search'])){ echo "'".$_GET['search']."'"; }else{echo "''";} @endphp;
        var logid = @php if(isset($_GET['logid'])){ echo "'".$_GET['logid']."'"; }else{echo "''";} @endphp;

        if(searchby=='username'){

            $('input[name=logid]').hide();
            $('input[name=logid]').prop('required',false);
            $('input[name=logid]').prop('disabled',true);

            $('input[name=search]').show();
            $('input[name=search]').prop('disabled',false);
            $('input[name=search]').prop('required',true);
            $('input[name=search]').val(username);

            $('select[name=filter]').hide();
            $('select[name=filter]').prop('required',false);
            $('select[name=filter]').prop('disabled',true);

        }else if(searchby=='statususername'){

            $('input[name=logid]').hide();
            $('input[name=logid]').prop('required',false);
            $('input[name=logid]').prop('disabled',true);

            $('input[name=search]').show();
            $('input[name=search]').prop('disabled',false);
            $('input[name=search]').prop('required',true);
            $('input[name=search]').val(username);

            $('select[name=filter]').show();
            $('select[name=filter]').prop('disabled',false);
            $('select[name=filter]').prop('required',true);

        }else if(searchby=='logid'){

            $('input[name=logid]').show();
            $('input[name=logid]').prop('disabled',false);
            $('input[name=logid]').prop('required',true);
            $('input[name=logid]').val(logid);

            $('input[name=search]').hide();
            $('input[name=search]').prop('required',false);
            $('input[name=search]').prop('disabled',true);

            $('select[name=filter]').hide();
            $('select[name=filter]').prop('required',false);
            $('select[name=filter]').prop('disabled',true);

        }else if(searchby=='status'){

            $('input[name=logid]').hide();
            $('input[name=logid]').prop('required',false);
            $('input[name=logid]').prop('disabled',true);

            $('input[name=search]').hide();
            $('input[name=search]').prop('required',false);
            $('input[name=search]').prop('disabled',true);

            $('select[name=filter]').show();
            $('select[name=filter]').prop('disabled',false);
            $('select[name=filter]').prop('required',true);

        }
    });

    $('select[name=searchby]').on('change',function(){

        var searchby = $(this).val();

        if(searchby=='status'){

            $('input[name=logid]').hide();
            $('input[name=logid]').prop('required',false);
            $('input[name=logid]').prop('disabled',true);

            $('input[name=search]').hide();
            $('input[name=search]').prop('required',false);
            $('input[name=search]').prop('disabled',true);

            $('select[name=filter]').show();
            $('select[name=filter]').prop('disabled',false);
            $('select[name=filter]').prop('required',true);

        }else if(searchby=='username'){

            $('input[name=logid]').hide();
            $('input[name=logid]').prop('required',false);
            $('input[name=logid]').prop('disabled',true);

            $('input[name=search]').show();
            $('input[name=search]').prop('disabled',false);
            $('input[name=search]').prop('required',true);

            $('select[name=filter]').hide();
            $('select[name=filter]').prop('required',false);
            $('select[name=filter]').prop('disabled',true);

        }else if(searchby=='statususername'){

            $('input[name=logid]').hide();
            $('input[name=logid]').prop('required',false);
            $('input[name=logid]').prop('disabled',true);

            $('input[name=search]').show();
            $('input[name=search]').prop('disabled',false);
            $('input[name=search]').prop('required',true);

            $('select[name=filter]').show();
            $('select[name=filter]').prop('disabled',false);
            $('select[name=filter]').prop('required',true);

        }else if(searchby=='logid'){

            $('input[name=logid]').show();
            $('input[name=logid]').prop('disabled',false);
            $('input[name=logid]').prop('required',true);

            $('input[name=search]').hide();
            $('input[name=search]').prop('required',false);
            $('input[name=search]').prop('disabled',true);

            $('select[name=filter]').hide();
            $('select[name=filter]').prop('required',false);
            $('select[name=filter]').prop('disabled',true);

        }

        // alert(searchby);

    });
</script>

@endpush


