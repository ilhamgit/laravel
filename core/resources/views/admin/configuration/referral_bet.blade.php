@extends('admin.layouts.app')

@section('panel')

@php

//echo '<pre>';

//print_r($referral_list);

//echo '</pre>';

function dis_date($date){

    $time=strtotime($date);

    return date('Y m d',$time);
    
}


function is_time($time){

    $time=strtotime($time);

    return date('h:i a',$time);
    
}

@endphp
    <div class="row mb-5">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <h4 class="my-2 pl-2 d-inline-block">Auto Race (Monday - Thursday)</h4>
                    <a href="{{route('admin.configuration.referral.autorace')}}" class="btn btn-primary d-inline-block ml-auto float-right m-2">Update</a>
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light">
                            <thead>
                            <tr>
                                <th>@lang('Day of Week')</th>
                                <th>@lang('Hour')</th>
                                <th>@lang('Multiplier')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($referral_list['autoRaces'] as $item)
                                <tr>
                                    <td data-label="@lang('Day of Week')">
                                        <p class="font-weight-bold"> {{$item['dayOfWeek']}}</p>
                                    </td>

                                    <td data-label="@lang('Hour')">
                                        <p class="font-weight-bold"> {{$item['hour']}}</p>
                                    </td>
                                    <td data-label="@lang('Multiplier')">
                                        <p class="font-weight-bold"> {{$item['multiplier']}}</p>
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
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <h4 class="my-2 pl-2 d-inline-block">Ranking Race D1 (Friday)</h4>
                    <a href="{{route('admin.configuration.referral.raced1')}}" class="btn btn-primary d-inline-block ml-auto float-right m-2">Update</a>
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light">
                            <thead>
                            <tr>
                                <th>@lang('Day of Week')</th>
                                <th>@lang('Hour')</th>
                                <th>@lang('Multiplier')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($referral_list['rankingRaceD1s'] as $item)
                                <tr>
                                    <td data-label="@lang('Day of Week')">
                                        <p class="font-weight-bold"> {{$item['dayOfWeek']}}</p>
                                    </td>

                                    <td data-label="@lang('Hour')">
                                        <p class="font-weight-bold"> {{$item['hour']}}</p>
                                    </td>
                                    <td data-label="@lang('Multiplier')">
                                        <p class="font-weight-bold"> {{$item['multiplier']}}</p>
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
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <h4 class="my-2 pl-2 d-inline-block">Ranking Race D2 (Saturday)</h4>
                    <a href="{{route('admin.configuration.referral.raced2')}}" class="btn btn-primary d-inline-block ml-auto float-right m-2">Update</a>
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light">
                            <thead>
                            <tr>
                                <th>@lang('Day of Week')</th>
                                <th>@lang('Hour')</th>
                                <th>@lang('Multiplier')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($referral_list['rankingRaceD2s'] as $item)
                                <tr>
                                    <td data-label="@lang('Day of Week')">
                                        <p class="font-weight-bold"> {{$item['dayOfWeek']}}</p>
                                    </td>

                                    <td data-label="@lang('Hour')">
                                        <p class="font-weight-bold"> {{$item['hour']}}</p>
                                    </td>
                                    <td data-label="@lang('Multiplier')">
                                        <p class="font-weight-bold"> {{$item['multiplier']}}</p>
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
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <h4 class="my-2 pl-2 d-inline-block">Ranking Race D3 (Sunday)</h4>
                    <a href="{{route('admin.configuration.referral.raced3')}}" class="btn btn-primary d-inline-block ml-auto float-right m-2">Update</a>
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light">
                            <thead>
                            <tr>
                                <th>@lang('Day of Week')</th>
                                <th>@lang('Hour')</th>
                                <th>@lang('Multiplier')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($referral_list['rankingRaceD3s'] as $item)
                                <tr>
                                    <td data-label="@lang('Day of Week')">
                                        <p class="font-weight-bold"> {{$item['dayOfWeek']}}</p>
                                    </td>

                                    <td data-label="@lang('Hour')">
                                        <p class="font-weight-bold"> {{$item['hour']}}</p>
                                    </td>
                                    <td data-label="@lang('Multiplier')">
                                        <p class="font-weight-bold"> {{$item['multiplier']}}</p>
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
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <h4 class="my-2 pl-2">Lucky Races</h4>
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light">
                            <thead>
                            <tr>
                                <th>@lang('Day of Week')</th>
                                <th>@lang('Hour')</th>
                                <th>@lang('Multiplier')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($referral_list['luckyRaces'] as $item)
                                <tr>
                                    <td data-label="@lang('Day of Week')">
                                        <p class="font-weight-bold"> {{$item['dayOfWeek']}}</p>
                                    </td>

                                    <td data-label="@lang('Hour')">
                                        <p class="font-weight-bold"> {{$item['hour']}}</p>
                                    </td>
                                    <td data-label="@lang('Multiplier')">
                                        <p class="font-weight-bold"> {{$item['multiplier']}}</p>
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
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <h4 class="my-2 pl-2">Super Races</h4>
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light">
                            <thead>
                            <tr>
                                <th>@lang('Day of Week')</th>
                                <th>@lang('Hour')</th>
                                <th>@lang('Multiplier')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($referral_list['superRaces'] as $item)
                                <tr>
                                    <td data-label="@lang('Day of Week')">
                                        <p class="font-weight-bold"> {{$item['dayOfWeek']}}</p>
                                    </td>

                                    <td data-label="@lang('Hour')">
                                        <p class="font-weight-bold"> {{$item['hour']}}</p>
                                    </td>
                                    <td data-label="@lang('Multiplier')">
                                        <p class="font-weight-bold"> {{$item['multiplier']}}</p>
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
        </div>
    </div>

@endsection


