@extends('admin.layouts.app')

@section('panel')

@php

//echo '<pre>';

//print_r($season_list);

//echo '</pre>';

function dis_date($date){

    $time=strtotime($date);

    return date('Y-m-d',$time);
    
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
                    <div class="table-responsive">
                        <table class="table">
                            <tbody class="text-left">
                                <tr>
                                    <th class="text-left">Season Name:</th><td class="text-left">Season {{$season_list['seasonName']}}</td><th class="text-left">Start:</th><td class="text-left">{{dis_date($season_list['startDate'])}}</td>
                                </tr>
                                <tr>
                                    <th class="text-left">Lucky Race Date:</th><td class="text-left">{{dis_date($season_list['luckyRaceDate'])}}</td><th class="text-left">Super Race Date:</th><td class="text-left">{{dis_date($season_list['superRaceDate'])}}</td>
                                </tr>
                                <tr>
                                    <th class="text-left">Next Day of Week:</th><td class="text-left">{{$season_list['recurringNextDayOfWeek']}}</td><th class="text-left">Next Gap:</th><td class="text-left">{{$season_list['recurringNextGap']}}</td>
                                </tr>
                                <tr>
                                    <th class="text-left">Minimum Horse:</th><td class="text-left">{{$season_list['recurringMinimumHorse']}}</td><th class="text-left">Auto Filled Weekdays:</th><td class="text-left">@php if($season_list['isAutoFilledWeekdays']==1){echo '<p class="font-weight-bold text-success">Yes</p>';}else{echo '<p class="font-weight-bold text-danger">No</p>';} @endphp</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <h4 class="my-2 pl-2">Auto Race (Monday - Thursday)</h4>
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light">
                            <thead>
                            <tr>
                                <th>@lang('Day of Week')</th>
                                <th>@lang('Match Daily Start Time')</th>
                                <th>@lang('Match Daily End Time')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($season_list['autoRaces'] as $item)
                                <tr>
                                    <td data-label="@lang('Day of Week')">
                                        <p class="font-weight-bold"> {{$item['dayOfWeek']}}</p>
                                    </td>

                                    <td data-label="@lang('Match Daily Start Time')">
                                        <p class="font-weight-bold"> {{is_time($item['matchDailyStartTime'])}}</p>
                                    </td>
                                    <td data-label="@lang('Match Daily End Time')">
                                        <p class="font-weight-bold"> {{is_time($item['matchDailyEndTime'])}}</p>
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
                    <h4 class="my-2 pl-2">Ranking Race D1 (Friday)</h4>
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light">
                            <thead>
                            <tr>
                                <th>@lang('Day of Week')</th>
                                <th>@lang('Match Daily Start Time')</th>
                                <th>@lang('Match Daily End Time')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($season_list['rankingRaceD1s'] as $item)
                                <tr>
                                    <td data-label="@lang('Day of Week')">
                                        <p class="font-weight-bold"> {{$item['dayOfWeek']}}</p>
                                    </td>

                                    <td data-label="@lang('Match Daily Start Time')">
                                        <p class="font-weight-bold"> {{is_time($item['matchDailyStartTime'])}}</p>
                                    </td>
                                    <td data-label="@lang('Match Daily End Time')">
                                        <p class="font-weight-bold"> {{is_time($item['matchDailyEndTime'])}}</p>
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
                    <h4 class="my-2 pl-2">Ranking Race D2 (Saturday)</h4>
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light">
                            <thead>
                            <tr>
                                <th>@lang('Day of Week')</th>
                                <th>@lang('Match Daily Start Time')</th>
                                <th>@lang('Match Daily End Time')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($season_list['rankingRaceD2s'] as $item)
                                <tr>
                                    <td data-label="@lang('Day of Week')">
                                        <p class="font-weight-bold"> {{$item['dayOfWeek']}}</p>
                                    </td>

                                    <td data-label="@lang('Match Daily Start Time')">
                                        <p class="font-weight-bold"> {{is_time($item['matchDailyStartTime'])}}</p>
                                    </td>
                                    <td data-label="@lang('Match Daily End Time')">
                                        <p class="font-weight-bold"> {{is_time($item['matchDailyEndTime'])}}</p>
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
                    <h4 class="my-2 pl-2">Ranking Race D3 (Sunday)</h4>
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light">
                            <thead>
                            <tr>
                                <th>@lang('Day of Week')</th>
                                <th>@lang('Match Daily Start Time')</th>
                                <th>@lang('Match Daily End Time')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($season_list['rankingRaceD3s'] as $item)
                                <tr>
                                    <td data-label="@lang('Day of Week')">
                                        <p class="font-weight-bold"> {{$item['dayOfWeek']}}</p>
                                    </td>

                                    <td data-label="@lang('Match Daily Start Time')">
                                        <p class="font-weight-bold"> {{is_time($item['matchDailyStartTime'])}}</p>
                                    </td>
                                    <td data-label="@lang('Match Daily End Time')">
                                        <p class="font-weight-bold"> {{is_time($item['matchDailyEndTime'])}}</p>
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
                                <th>@lang('Match Daily Start Time')</th>
                                <th>@lang('Match Daily End Time')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($season_list['luckyRaces'] as $item)
                                <tr>
                                    <td data-label="@lang('Day of Week')">
                                        <p class="font-weight-bold"> {{$item['dayOfWeek']}}</p>
                                    </td>

                                    <td data-label="@lang('Match Daily Start Time')">
                                        <p class="font-weight-bold"> {{is_time($item['matchDailyStartTime'])}}</p>
                                    </td>
                                    <td data-label="@lang('Match Daily End Time')">
                                        <p class="font-weight-bold"> {{is_time($item['matchDailyEndTime'])}}</p>
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
                                <th>@lang('Match Daily Start Time')</th>
                                <th>@lang('Match Daily End Time')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($season_list['superRaces'] as $item)
                                <tr>
                                    <td data-label="@lang('Day of Week')">
                                        <p class="font-weight-bold"> {{$item['dayOfWeek']}}</p>
                                    </td>

                                    <td data-label="@lang('Match Daily Start Time')">
                                        <p class="font-weight-bold"> {{is_time($item['matchDailyStartTime'])}}</p>
                                    </td>
                                    <td data-label="@lang('Match Daily End Time')">
                                        <p class="font-weight-bold"> {{is_time($item['matchDailyEndTime'])}}</p>
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


@push('breadcrumb-plugins')
<div class="d-flex flex-wrap justify-content-end flex-gap-8">
        <a href="{{route('admin.configuration.season.update')}}"><button type="button" class="btn btn--primary cuModalBtn">@lang('Update')</button>
    </div>
@endpush