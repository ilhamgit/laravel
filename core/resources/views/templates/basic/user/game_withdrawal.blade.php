@extends($activeTemplate.'layouts.userfrontend')
@section('content')
    @include($activeTemplate.'partials.breadcrumb')

    @php

    $withdraw_list=array();

    foreach($widget['Withdrawals'] as $status => $dp_data){

      foreach($dp_data as $no => $data){

        $withdraw_list[$no]=$data;

      }

    }

    @endphp 

    <section class="bg--section">
        <div class="text-uppercase">
            <div class="text-right mb-3" style="margin-top: -7%;">
                <a href="{{  url('user/dashboard') }}"><button type="button" class="btn btn-golden px-3 py-2">Back</button></a>
            </div>
            <div class="table-responsive">
                      <table class="table table-dark text-center">
                        <thead>
                            <tr>
                              <th scope="col">#</th>
                              <th scope="col">Log ID</th>
                              <th scope="col">Action Type</th>
                              <th scope="col">Status</th>
                              <th scope="col">Value</th>
                              <th scope="col">Deposit Date</th>
                            </tr>
                          </thead>
                          <tbody>
                            @forelse ($withdraw_list as $no => $w_data)
    
                                <tr>
                                    <th scope="row">{{$no+1}}</th>
                                    <td>{{$w_data->logId }}</td>
                                    <td>{{$w_data->actionType }}</td>
                                    <td>{{$w_data->status }}</td>
                                    <td class="bg-success">{{$w_data->value }}</td>
                                    <td>@php $mdate=strtotime($w_data->createdDate ); echo date('d M y (h:i a)',$mdate); @endphp</td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No Deposit yet.</td>
                                </tr>

                            @endforelse
                          </tbody>
                      </table>
                    </div>

        </div>
    </section>

@endsection

