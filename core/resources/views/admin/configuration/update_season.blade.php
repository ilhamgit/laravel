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
                                <form method="post">
                                    <tr>
                                        <th class="text-left">Next Day of Week:</th>
                                        <td class="text-left">@csrf<input type="number" name="nextday" class="form-control" value="{{$season_list['recurringNextDayOfWeek']}}" min="0" max="6"></td>
                                        <th class="text-left">Next Gap:</th>
                                        <td class="text-left"><input type="number" name="nextgap" class="form-control" value="{{$season_list['recurringNextGap']}}"></td>
                                        <th class="text-left">Minimum Horse:</th>
                                        <td class="text-left"><input type="number" name="minhorse" class="form-control" value="{{$season_list['recurringMinimumHorse']}}"></td>
                                        <td class="text-right"><button type="submit" class="btn btn--primary">Update</button></td>
                                    </tr>
                                </form>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('breadcrumb-plugins')
<div class="d-flex flex-wrap justify-content-end flex-gap-8">
        <a href="{{route('admin.configuration.season')}}"><button type="button" class="btn btn--primary">@lang('Back')</button></a>
    </div>
@endpush


