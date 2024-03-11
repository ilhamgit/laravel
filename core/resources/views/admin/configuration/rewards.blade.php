@extends('admin.layouts.app')

@section('panel')

@php

//echo '<pre>';

//print_r($rewards_list);

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
                    <a href="{{route('admin.configuration.rewards.autorace')}}" class="btn btn-primary d-inline-block ml-auto float-right m-2">Update</a>
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light">
                            <thead>
                            <tr>
                                <th>@lang('Player Ranking')</th>
                                <th>@lang('Rewards (G)')</th>
                                <th>@lang('Ranking Score')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($rewards_list['autoRaces'] as $item)
                                <tr>
                                    <td data-label="@lang('Player Ranking')">
                                        <p class="font-weight-bold"> {{$item['playerRanking']}}</p>
                                    </td>

                                    <td data-label="@lang('Rewards (G)')">
                                        <p class="font-weight-bold"> {{$item['g']}}</p>
                                    </td>
                                    <td data-label="@lang('Ranking Score')">
                                        <p class="font-weight-bold"> {{$item['rankingScore']}}</p>
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
                    <a href="{{route('admin.configuration.rewards.raced1')}}" class="btn btn-primary d-inline-block ml-auto float-right m-2">Update</a>
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light">
                            <thead>
                            <tr>
                                <th>@lang('Player Ranking')</th>
                                <th>@lang('Rewards (G)')</th>
                                <th>@lang('Ranking Score')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($rewards_list['rankingRaceD1s'] as $item)
                                <tr>
                                    <td data-label="@lang('Player Ranking')">
                                        <p class="font-weight-bold"> {{$item['playerRanking']}}</p>
                                    </td>

                                    <td data-label="@lang('Rewards (G)')">
                                        <p class="font-weight-bold"> {{$item['g']}}</p>
                                    </td>
                                    <td data-label="@lang('Ranking Score')">
                                        <p class="font-weight-bold"> {{$item['rankingScore']}}</p>
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
                    <a href="{{route('admin.configuration.rewards.raced2')}}" class="btn btn-primary d-inline-block ml-auto float-right m-2">Update</a>
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light">
                            <thead>
                            <tr>
                                <th>@lang('Player Ranking')</th>
                                <th>@lang('Rewards (G)')</th>
                                <th>@lang('Ranking Score')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($rewards_list['rankingRaceD2s'] as $item)
                                <tr>
                                    <td data-label="@lang('Player Ranking')">
                                        <p class="font-weight-bold"> {{$item['playerRanking']}}</p>
                                    </td>

                                    <td data-label="@lang('Rewards (G)')">
                                        <p class="font-weight-bold"> {{$item['g']}}</p>
                                    </td>
                                    <td data-label="@lang('Ranking Score')">
                                        <p class="font-weight-bold"> {{$item['rankingScore']}}</p>
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
                    <a href="{{route('admin.configuration.rewards.raced3')}}" class="btn btn-primary d-inline-block ml-auto float-right m-2">Update</a>
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light">
                            <thead>
                            <tr>
                                <th>@lang('Player Ranking')</th>
                                <th>@lang('Rewards (G)')</th>
                                <th>@lang('Ranking Score')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($rewards_list['rankingRaceD3s'] as $item)
                                <tr>
                                    <td data-label="@lang('Player Ranking')">
                                        <p class="font-weight-bold"> {{$item['playerRanking']}}</p>
                                    </td>

                                    <td data-label="@lang('Rewards (G)')">
                                        <p class="font-weight-bold"> {{$item['g']}}</p>
                                    </td>
                                    <td data-label="@lang('Ranking Score')">
                                        <p class="font-weight-bold"> {{$item['rankingScore']}}</p>
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
                    <h4 class="my-2 pl-2 d-inline-block">Lucky Races</h4>
                    <a href="{{route('admin.configuration.rewards.luckyraces')}}" class="btn btn-primary d-inline-block ml-auto float-right m-2">Update</a>
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light">
                            <thead>
                            <tr>
                                <th>@lang('Player Ranking')</th>
                                <th>@lang('Rewards (G)')</th>
                                <th>@lang('Ranking Score')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($rewards_list['luckyRaces'] as $item)
                                <tr>
                                    <td data-label="@lang('Player Ranking')">
                                        <p class="font-weight-bold"> {{$item['playerRanking']}}</p>
                                    </td>

                                    <td data-label="@lang('Rewards (G)')">
                                        <p class="font-weight-bold"> {{$item['g']}}</p>
                                    </td>
                                    <td data-label="@lang('Ranking Score')">
                                        <p class="font-weight-bold"> {{$item['rankingScore']}}</p>
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
                    <h4 class="my-2 pl-2 d-inline-block">Super Races</h4>
                    <a href="{{route('admin.configuration.rewards.superraces')}}" class="btn btn-primary d-inline-block ml-auto float-right m-2">Update</a>
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light">
                            <thead>
                            <tr>
                                <th>@lang('Player Ranking')</th>
                                <th>@lang('Rewards (G)')</th>
                                <th>@lang('Ranking Score')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($rewards_list['superRaces'] as $item)
                                <tr>
                                    <td data-label="@lang('Player Ranking')">
                                        <p class="font-weight-bold"> {{$item['playerRanking']}}</p>
                                    </td>

                                    <td data-label="@lang('Rewards (G)')">
                                        <p class="font-weight-bold"> {{$item['g']}}</p>
                                    </td>
                                    <td data-label="@lang('Ranking Score')">
                                        <p class="font-weight-bold"> {{$item['rankingScore']}}</p>
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


