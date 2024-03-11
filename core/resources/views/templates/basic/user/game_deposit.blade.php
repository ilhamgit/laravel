@extends($activeTemplate.'layouts.userfrontend')
@section('content')
    @include($activeTemplate.'partials.breadcrumb')

    @php

    $depo_list=array();

    //echo '<pre class="text-white">';

    //print_r($widget['Deposits']);

    //echo '</pre>';

    foreach($widget['Deposits'] as $status => $dp_data){

      foreach($dp_data as $no => $data){

        $depo_list[$no]=$data;

      }

    }

    @endphp    

    <section class="bg--section">
        <div class="text-uppercase">
            <div class="text-right mb-3" style="margin-top: -7%;">
                <a href="{{  url('user/dashboard') }}"><button type="button" class="btn btn-golden px-3 py-2">@lang('Back')</button></a>
            </div>

            <div class="table-responsive">
                      <table class="table table-dark text-center w-md-100">
                        <thead>
                            <tr>
                              <th scope="col">#</th>
                              <th scope="col">@lang('Log ID')</th>
                              <th scope="col">@lang('Action Type')</th>
                              <th scope="col">@lang('Status')</th>
                              <th scope="col">@lang('Value')</th>
                              <th scope="col">@lang('Deposit Date')</th>
                            </tr>
                          </thead>
                          <tbody>
                            @forelse ($depo_list as $no => $d_data)
    
                                <tr>
                                    <th scope="row">{{$no+1}}</th>
                                    <td>{{$d_data->logId }}</td>
                                    <td>{{$d_data->actionType }}</td>
                                    <td>{{$d_data->status }}</td>
                                    <td class="bg-success">{{$d_data->value }}</td>
                                    <td>@php $mdate=strtotime($d_data->createdDate ); echo date('d M y (h:i a)',$mdate); @endphp</td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">@lang('No Deposit yet.')</td>
                                </tr>

                            @endforelse
                          </tbody>
                      </table>
                    </div>
        </div>
    </section>

@endsection

